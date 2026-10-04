const http = require('http');
const path = require('path');
const crypto = require('crypto');
const express = require('express');
const { Server } = require('socket.io');
const config = require('./config');
const store = require('./store');
const telegram = require('./telegram');

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: (origin, cb) => cb(null, !config.allowedOrigins.length || !origin || config.allowedOrigins.includes(origin)),
  },
});

app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

const agentTokens = new Set();
const MAX_TEXT = 2000;
const ID_RE = /^[a-zA-Z0-9-]{16,64}$/;
const PHONE_RE = /(?:\+?84|0)(?:[\s.-]?\d){9}/;

const clean = (s, max = MAX_TEXT) => String(s || '').trim().slice(0, max);
const onlineAgents = () => io.sockets.adapter.rooms.get('agents')?.size || 0;

function checkAgent(req, res, next) {
  const token = req.get('x-agent-token') || req.query.token;
  if (!agentTokens.has(token)) return res.status(401).json({ error: 'Chưa đăng nhập' });
  next();
}

// Cấu hình công khai cho widget.
app.get('/api/config', (req, res) => {
  const { project, welcome, intents } = config;
  const pa = config.proactive || {};
  res.json({
    project, welcome: fill(welcome), quickReplies: intents.map(q => q.label), agentsOnline: onlineAgents() > 0,
    proactive: pa.enabled ? {
      dwellSeconds: pa.dwellSeconds || 8,
      maxPerVisit: pa.maxPerVisit || 2,
      topics: intents.map((it, i) => ({ i, keywords: it.browse?.keywords || [] })).filter(t => t.keywords.length),
    } : null,
  });
});

// Mẫu câu theo kịch bản 4 bước cho trang tư vấn viên.
app.get('/api/agent/canned', checkAgent, (req, res) => {
  res.json({ cannedReplies: config.cannedReplies, zaloTransfer: config.zaloTransfer, project: config.project });
});

app.post('/api/agent/login', (req, res) => {
  const a = Buffer.from(String(req.body?.password || ''));
  const b = Buffer.from(config.agentPassword);
  if (a.length !== b.length || !crypto.timingSafeEqual(a, b)) return res.status(401).json({ error: 'Sai mật khẩu' });
  const token = crypto.randomBytes(24).toString('hex');
  agentTokens.add(token);
  res.json({ token });
});

app.get('/api/leads.csv', checkAgent, (req, res) => {
  const esc = v => `"${String(v ?? '').replace(/"/g, '""')}"`;
  const rows = [['Thời gian', 'Họ tên', 'Số điện thoại', 'Ghi chú', 'Trạng thái', 'Trang', 'Tin nhắn cuối']];
  for (const c of store.list()) {
    rows.push([
      new Date(c.createdAt).toLocaleString('vi-VN'), c.lead.name, c.lead.phone, c.lead.note,
      c.status, c.page, c.lastMessage?.text,
    ]);
  }
  res.setHeader('Content-Type', 'text/csv; charset=utf-8');
  res.setHeader('Content-Disposition', 'attachment; filename="casamia-balanca-leads.csv"');
  res.send('﻿' + rows.map(r => r.map(esc).join(',')).join('\r\n'));
});

async function pushLead(conv) {
  if (!config.leadWebhookUrl) return;
  try {
    await fetch(config.leadWebhookUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        source: 'livechat', project: config.project.name, conversationId: conv.id,
        name: conv.lead.name, phone: conv.lead.phone, note: conv.lead.note,
        page: conv.page, createdAt: new Date(conv.createdAt).toISOString(),
      }),
    });
  } catch (e) {
    console.error('Gửi lead webhook lỗi:', e.message);
  }
}

function setLead(conv, fields) {
  const hadPhone = Boolean(conv.lead.phone);
  const lead = { ...conv.lead };
  for (const k of ['name', 'phone', 'note']) if (fields[k]) lead[k] = clean(fields[k], 200);
  store.update(conv.id, { lead });
  io.to('agents').emit('conversation:update', store.summary(conv));
  io.to(`conv:${conv.id}`).emit('lead:saved', lead);
  if (!hadPhone && lead.phone) {
    pushLead(conv);
    telegram.notifyLead(conv);
  }
}

function sendMessage(conv, msg) {
  const m = store.addMessage(conv.id, msg);
  io.to(`conv:${conv.id}`).emit('message', m);
  io.to('agents').emit('message', { conversationId: conv.id, message: m });
  io.to('agents').emit('conversation:update', store.summary(conv));
  return m;
}

// Thay biến {name}, {phone}, {zalo}, {hotline}, {project} trong câu mẫu.
function fill(tpl, conv) {
  const vars = {
    name: conv?.lead?.name || 'anh/chị',
    phone: conv?.lead?.phone || '',
    zalo: config.project.zalo,
    hotline: config.project.hotline,
    project: config.project.name,
  };
  const out = tpl.replace(/\{(\w+)\}/g, (m, k) => (k in vars ? vars[k] : m));
  return out.charAt(0).toUpperCase() + out.slice(1);
}

// Gửi lần lượt từng câu như người thật đang gõ. Chuỗi mới (hoặc tư vấn viên trả lời) huỷ chuỗi cũ còn dở.
const pendingAuto = new Map(); // conversationId -> timers
function cancelAuto(id) {
  (pendingAuto.get(id) || []).forEach(clearTimeout);
  pendingAuto.delete(id);
}
function systemReply(conv, texts, extra = {}) {
  cancelAuto(conv.id);
  const timers = [];
  [].concat(texts).forEach((text, i, all) => {
    const last = i === all.length - 1;
    timers.push(setTimeout(() => {
      io.to(`conv:${conv.id}`).emit('typing');
      timers.push(setTimeout(() => sendMessage(conv, { from: 'agent', text: fill(text, conv), auto: true, ...(last ? extra : {}) }), 900));
    }, i * 1600 + 300));
  });
  pendingAuto.set(conv.id, timers);
}

const zaloStep = () => [config.zaloTransfer, { action: 'zalo' }];

const kwRegex = kw => new RegExp(`(^|[^\\p{L}])${kw.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}([^\\p{L}]|$)`, 'iu');
const intentKeywords = config.intents.map(it => ({ it, res: it.keywords.map(kwRegex) }));

function findIntent(text, byKeyword) {
  const byLabel = config.intents.find(it => it.label === text);
  if (byLabel || !byKeyword) return byLabel;
  return intentKeywords.find(({ res }) => res.some(r => r.test(text)))?.it;
}

// Kịch bản 4 bước: ghi nhận → phương án → xin thông tin (hoặc chuyển Zalo nếu đã có SĐT).
function replyIntent(conv, intent) {
  const [ack, option, ask] = intent.steps;
  if (conv.lead.phone) systemReply(conv, [ack, option, zaloStep()[0]], zaloStep()[1]);
  else systemReply(conv, [ack, option, ask]);
}

function throttle(socket) {
  const now = Date.now();
  socket.data.hits = (socket.data.hits || []).filter(t => now - t < 10000);
  socket.data.hits.push(now);
  return socket.data.hits.length > 15;
}

io.on('connection', socket => {
  const { role, token, visitorId } = socket.handshake.auth || {};

  if (role === 'agent') {
    if (!agentTokens.has(token)) return socket.emit('auth:error'), socket.disconnect(true);
    socket.join('agents');
    socket.emit('conversations', store.list());
    io.emit('agents:online', onlineAgents() > 0);

    socket.on('conversation:open', (id, ack) => {
      const conv = store.get(id);
      if (!conv) return ack?.(null);
      store.update(id, { unread: 0 });
      io.to('agents').emit('conversation:update', store.summary(conv));
      ack?.(conv);
    });

    socket.on('message', ({ conversationId, text, action } = {}) => agentReply(conversationId, text, action));

    socket.on('typing', conversationId => io.to(`conv:${conversationId}`).emit('typing'));

    socket.on('conversation:status', ({ conversationId, status } = {}) => {
      const conv = store.get(conversationId);
      if (!conv || !['new', 'contacted', 'closed'].includes(status)) return;
      store.update(conv.id, { status });
      io.to('agents').emit('conversation:update', store.summary(conv));
    });

    socket.on('lead:update', ({ conversationId, ...fields } = {}) => {
      const conv = store.get(conversationId);
      if (conv) setLead(conv, fields);
    });

    socket.on('disconnect', () => io.emit('agents:online', onlineAgents() > 0));
    return;
  }

  // Khách truy cập
  if (!ID_RE.test(visitorId || '')) return socket.disconnect(true);
  const meta = socket.handshake.auth;
  socket.join(`conv:${visitorId}`);
  const existing = store.get(visitorId);
  socket.emit('history', {
    messages: existing?.messages || [],
    lead: existing?.lead || null,
    agentsOnline: onlineAgents() > 0,
  });

  socket.on('message', ({ text } = {}) => {
    text = clean(text);
    if (!text || throttle(socket)) return;
    const isNew = !store.get(visitorId);
    const conv = store.ensure(visitorId, { page: clean(meta.page, 500), referrer: clean(meta.referrer, 500) });
    if (isNew) io.to('agents').emit('conversation:new', store.summary(conv));
    sendMessage(conv, { from: 'visitor', text });

    const agentsOn = onlineAgents() > 0;
    // Tin đầu tiên của khách luôn báo (kể cả khi trước đó bot đã chủ động hỏi).
    const firstFromVisitor = conv.messages.filter(m => m.from === 'visitor').length === 1;
    telegram.notifyMessage(conv, text, { isNew: firstFromVisitor, agentsOnline: agentsOn });
    const phone = text.match(PHONE_RE)?.[0].replace(/[\s.-]/g, '');
    if (phone && !conv.lead.phone) {
      setLead(conv, { phone });
      // Khách vừa cho SĐT: ghi nhận + chuyển Zalo (khi có tư vấn viên thì để người trả lời).
      if (!agentsOn) systemReply(conv, [config.leadThanks, zaloStep()[0]], zaloStep()[1]);
      return;
    }

    // Nút hỏi nhanh luôn trả lời tự động; khách tự gõ thì chỉ tự động khi chưa có tư vấn viên.
    const intent = findIntent(text, !agentsOn);
    if (intent) {
      replyIntent(conv, intent);
      setTimeout(() => !store.get(visitorId)?.lead.phone && socket.emit('lead:request'), 5200);
      return;
    }
    if (!agentsOn && !conv.lead.phone && !conv.offlineNotified) {
      store.update(conv.id, { offlineNotified: true });
      systemReply(conv, config.fallback);
      setTimeout(() => !store.get(visitorId)?.lead.phone && socket.emit('lead:request'), 5200);
    }
  });

  socket.on('lead', fields => {
    if (throttle(socket)) return;
    const phone = String(fields?.phone || '').match(PHONE_RE)?.[0].replace(/[\s.-]/g, '');
    if (!phone) return socket.emit('lead:error', 'Số điện thoại chưa đúng, anh/chị kiểm tra lại giúp em ạ.');
    const conv = store.ensure(visitorId, { page: clean(meta.page, 500) });
    setLead(conv, { name: fields.name, phone });
    sendMessage(conv, {
      from: 'visitor',
      text: `📋 Thông tin liên hệ: ${conv.lead.name || ''} – ${conv.lead.phone || ''}`.trim(),
    });
    systemReply(conv, [config.leadThanks, zaloStep()[0]], zaloStep()[1]);
  });

  // Khách đọc chậm ở một mục trên trang → chủ động hỏi đúng mục đó.
  socket.on('browse', ({ topic, seconds } = {}) => {
    const pa = config.proactive || {};
    const intent = config.intents[topic];
    if (!pa.enabled || !intent?.browse || throttle(socket)) return;
    const isNew = !store.get(visitorId);
    const conv = store.ensure(visitorId, { page: clean(meta.page, 500), referrer: clean(meta.referrer, 500) });
    const asked = conv.proactiveAsked || [];
    const last = conv.messages.filter(m => m.from !== 'system').pop();
    if (asked.includes(topic) || asked.length >= (pa.maxPerVisit || 2)) return;
    if (last && Date.now() - last.at < (pa.quietSeconds || 45) * 1000) return;
    if (pendingAuto.has(conv.id)) return;
    store.update(conv.id, { proactiveAsked: [...asked, topic] });
    if (isNew) io.to('agents').emit('conversation:new', store.summary(conv));
    const topicName = intent.label.replace(/^\P{L}+/u, '');
    const secs = Math.min(Number(seconds) || pa.dwellSeconds || 8, 600);
    sendMessage(conv, { from: 'system', text: `👀 Khách đọc chậm ở mục "${topicName}" (${secs} giây) – đã chủ động hỏi` });
    systemReply(conv, [intent.browse.question], { proactive: true });
    telegram.notifyBrowse(conv, topicName, secs, fill(intent.browse.question, conv));
  });

  socket.on('typing', () => io.to('agents').emit('typing', visitorId));
});

// Tư vấn viên trả lời từ Telegram.
function agentReply(conversationId, text, action) {
  const conv = store.get(conversationId);
  text = clean(text) || (action === 'zalo' ? fill(config.zaloTransfer, conv) : '');
  if (!conv || !text) return false;
  cancelAuto(conv.id);
  store.update(conv.id, { unread: 0, status: conv.status === 'new' ? 'contacted' : conv.status });
  sendMessage(conv, { from: 'agent', text, ...(action === 'zalo' ? { action } : {}) });
  return true;
}

server.listen(config.port, () => {
  console.log(`Live chat ${config.project.name} chạy tại http://localhost:${config.port}`);
  console.log(`  • Trang demo:        http://localhost:${config.port}/`);
  console.log(`  • Trang tư vấn viên: http://localhost:${config.port}/agent.html`);
  telegram.start(agentReply);
  if (config.agentPassword === 'doimatkhau') console.warn('  ⚠ Đang dùng mật khẩu mặc định – hãy đặt AGENT_PASSWORD.');
});
