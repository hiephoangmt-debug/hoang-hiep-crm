const http = require('http');
const path = require('path');
const crypto = require('crypto');
const express = require('express');
const { Server } = require('socket.io');
const config = require('./config');
const store = require('./store');

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
  const { project, welcome, quickReplies } = config;
  res.json({ project, welcome, quickReplies: quickReplies.map(q => q.label), agentsOnline: onlineAgents() > 0 });
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
  if (!hadPhone && lead.phone) pushLead(conv);
}

function sendMessage(conv, msg) {
  const m = store.addMessage(conv.id, msg);
  io.to(`conv:${conv.id}`).emit('message', m);
  io.to('agents').emit('message', { conversationId: conv.id, message: m });
  io.to('agents').emit('conversation:update', store.summary(conv));
  return m;
}

function systemReply(conv, text) {
  setTimeout(() => sendMessage(conv, { from: 'agent', text, auto: true }), 700);
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

    socket.on('message', ({ conversationId, text } = {}) => {
      const conv = store.get(conversationId);
      text = clean(text);
      if (!conv || !text) return;
      store.update(conv.id, { unread: 0, status: conv.status === 'new' ? 'contacted' : conv.status });
      sendMessage(conv, { from: 'agent', text });
    });

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

    const phone = text.match(PHONE_RE)?.[0].replace(/[\s.-]/g, '');
    if (phone && !conv.lead.phone) setLead(conv, { phone });

    const quick = config.quickReplies.find(q => q.label === text);
    if (quick?.reply) return systemReply(conv, quick.reply);
    if (!onlineAgents() && !conv.lead.phone && !conv.offlineNotified) {
      store.update(conv.id, { offlineNotified: true });
      systemReply(conv, config.offlineReply);
      setTimeout(() => socket.emit('lead:request'), 800);
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
    systemReply(conv, `Cảm ơn ${conv.lead.name || 'anh/chị'}! Em sẽ liên hệ lại qua số ${conv.lead.phone} trong thời gian sớm nhất ạ.`);
  });

  socket.on('typing', () => io.to('agents').emit('typing', visitorId));
});

server.listen(config.port, () => {
  console.log(`Live chat ${config.project.name} chạy tại http://localhost:${config.port}`);
  console.log(`  • Trang demo:        http://localhost:${config.port}/`);
  console.log(`  • Trang tư vấn viên: http://localhost:${config.port}/agent.html`);
  if (config.agentPassword === 'doimatkhau') console.warn('  ⚠ Đang dùng mật khẩu mặc định – hãy đặt AGENT_PASSWORD.');
});
