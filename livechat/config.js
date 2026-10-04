// Cấu hình live chat dự án Casamia Balanca.
// Sửa các giá trị bên dưới (hoặc đặt biến môi trường) cho đúng thông tin thực tế.
//
// KỊCH BẢN PHẢN HỒI 4 BƯỚC (áp dụng cho mọi câu trả lời):
//   1. Dạ ghi nhận      – xác nhận nhu cầu của khách, thể hiện đã lắng nghe
//   2. Đưa phương án    – gợi ý hướng giải quyết / lựa chọn phù hợp
//   3. Dẫn dắt xin TT   – hỏi tên, SĐT, nhu cầu để tư vấn sát hơn
//   4. Chuyển Zalo      – mời khách kết bạn Zalo để gửi tài liệu, chăm sóc tiếp
//
// Biến dùng được trong câu trả lời: {name} (tên khách hoặc "anh/chị"), {zalo}, {hotline}, {project}
// Đọc file .env (nếu có) để khỏi phải gõ biến môi trường mỗi lần chạy.
const fs = require('fs');
try {
  for (const line of fs.readFileSync(require('path').join(__dirname, '.env'), 'utf8').split(/\r?\n/)) {
    const m = line.match(/^\s*([A-Z_][A-Z0-9_]*)\s*=\s*(.*?)\s*$/);
    if (m && process.env[m[1]] === undefined) process.env[m[1]] = m[2].replace(/^(['"])(.*)\1$/, '$2');
  }
} catch {}

module.exports = {
  port: Number(process.env.PORT) || 3000,

  // Mật khẩu đăng nhập trang tư vấn viên (/agent.html). BẮT BUỘC đổi khi chạy thật.
  agentPassword: process.env.AGENT_PASSWORD || 'doimatkhau',

  // (Tuỳ chọn) URL nhận lead dạng JSON POST: Google Apps Script, LadiPage, Zapier, n8n...
  leadWebhookUrl: process.env.LEAD_WEBHOOK_URL || '',

  // Danh sách domain được phép nhúng widget. Để trống = cho phép tất cả.
  allowedOrigins: (process.env.ALLOWED_ORIGINS || '').split(',').map(s => s.trim()).filter(Boolean),

  project: {
    name: 'Casamia Balanca',
    agentName: 'Hoàng Hiệp',
    agentTitle: 'Chuyên viên tư vấn dự án',
    hotline: process.env.HOTLINE || '0900000000',
    zalo: process.env.ZALO || '0900000000',
    primaryColor: '#0b2a5b',
    accentColor: '#f47c20',
  },

  welcome:
    'Dạ em chào {name} 👋 Em là Hiệp – chuyên viên tư vấn dự án {project}. ' +
    'Anh/chị đang quan tâm đến thông tin nào để em hỗ trợ mình nhanh nhất ạ?',

  // Câu mời chuyển Zalo (bước 4). Tin nhắn này hiển thị kèm nút "Chat Zalo".
  zaloTransfer:
    'Dạ để em gửi {name} trọn bộ tài liệu (bảng giá, mặt bằng, chính sách, hình ảnh thực tế) cho tiện xem lại, ' +
    'mình kết bạn Zalo {zalo} với em nhé. Em đã chuẩn bị sẵn tài liệu, {name} bấm nút bên dưới là nhận được ngay ạ 👇',

  // Khách vừa để lại SĐT → ghi nhận + chuyển Zalo.
  leadThanks:
    'Dạ em đã ghi nhận thông tin của {name} rồi ạ. Em sẽ gọi lại cho mình qua số {phone} trong ít phút để tư vấn chi tiết.',

  // Khách nhắn nội dung không khớp chủ đề nào, khi chưa có tư vấn viên trực tuyến.
  fallback: [
    'Dạ em ghi nhận câu hỏi của {name} rồi ạ.',
    'Nội dung này em cần tư vấn kỹ theo đúng nhu cầu của mình để không thiếu thông tin quan trọng.',
    '{name} cho em xin tên và số điện thoại/Zalo, em gọi lại giải đáp chi tiết ngay nhé ạ.',
  ],

  // Chủ đề tư vấn. "label" = nút hỏi nhanh trên widget; "keywords" = tự nhận diện khi khách tự gõ.
  // steps = [ghi nhận, phương án, dẫn dắt xin thông tin]. Khi khách đã có SĐT, bước 3 được thay bằng chuyển Zalo.
  // Nội dung phương án đang viết chung – hãy bổ sung số liệu thực tế của dự án.
  intents: [
    {
      label: '💰 Bảng giá & chính sách',
      keywords: ['giá', 'gia', 'bao nhiêu', 'chính sách', 'chiết khấu', 'ưu đãi', 'thanh toán', 'tiền'],
      steps: [
        'Dạ em ghi nhận {name} đang quan tâm bảng giá và chính sách bán hàng ạ.',
        'Hiện dự án có nhiều phương án thanh toán: thanh toán chuẩn theo tiến độ, thanh toán sớm nhận chiết khấu, hoặc hỗ trợ vay ngân hàng. Giá mỗi căn khác nhau theo vị trí, diện tích và hướng.',
        'Để em lọc đúng căn và tính dòng tiền phù hợp, {name} cho em hỏi ngân sách dự kiến khoảng bao nhiêu và mình mua để ở hay đầu tư ạ?',
      ],
      // Khách đọc chậm ở mục có các từ này trên trang -> chủ động hỏi câu dưới.
      browse: {
        keywords: ["giá", "bảng giá", "giá bán", "chính sách", "thanh toán", "ưu đãi", "chiết khấu"],
        question:
          "Dạ em thấy anh/chị đang xem kỹ phần giá và chính sách ạ. Mỗi căn có giá và ưu đãi khác nhau – anh/chị đang nhắm căn nào để em tính thử dòng tiền cụ thể cho mình nhé?",
      },
    },
    {
      label: '🏠 Mặt bằng & loại sản phẩm',
      keywords: ['mặt bằng', 'diện tích', 'loại', 'căn', 'phòng ngủ', 'pn', 'biệt thự', 'shophouse', 'nhà phố'],
      steps: [
        'Dạ em ghi nhận {name} muốn xem mặt bằng và các loại sản phẩm ạ.',
        'Dự án có nhiều dòng sản phẩm với diện tích và vị trí khác nhau; em có thể gợi ý 2–3 lựa chọn đúng nhu cầu kèm mặt bằng chi tiết từng căn.',
        '{name} cho em biết mình cần khoảng mấy phòng ngủ, gia đình mấy người để em chọn mặt bằng phù hợp nhất ạ?',
      ],
      // Khách đọc chậm ở mục có các từ này trên trang -> chủ động hỏi câu dưới.
      browse: {
        keywords: ["mặt bằng", "sản phẩm", "loại hình", "diện tích", "thiết kế", "biệt thự", "shophouse", "nhà phố", "căn hộ"],
        question:
          "Dạ anh/chị đang xem mặt bằng và sản phẩm ạ? Em gửi mình mặt bằng chi tiết đúng nhu cầu nhé – gia đình mình cần khoảng mấy phòng ngủ ạ?",
      },
    },
    {
      label: '📍 Vị trí & tiện ích',
      keywords: ['vị trí', 'ở đâu', 'đường', 'tiện ích', 'gần', 'trường', 'chợ', 'biển', 'bản đồ'],
      steps: [
        'Dạ em ghi nhận {name} đang tìm hiểu vị trí và tiện ích dự án ạ.',
        'Em có sẵn bản đồ vị trí, sơ đồ kết nối và danh sách tiện ích nội khu – ngoại khu; nếu tiện, em sắp xếp đưa mình đi xem thực tế luôn.',
        '{name} đang ở khu vực nào ạ? Em gửi lộ trình và thời gian di chuyển cụ thể cho mình nhé.',
      ],
      // Khách đọc chậm ở mục có các từ này trên trang -> chủ động hỏi câu dưới.
      browse: {
        keywords: ["vị trí", "tiện ích", "kết nối", "bản đồ", "liên kết vùng", "ngoại khu", "nội khu"],
        question:
          "Dạ anh/chị đang tìm hiểu vị trí và tiện ích ạ? Anh/chị đang ở khu vực nào để em gửi lộ trình và thời gian di chuyển cụ thể cho mình nhé.",
      },
    },
    {
      label: '📜 Pháp lý & tiến độ',
      keywords: ['pháp lý', 'sổ', 'giấy tờ', 'tiến độ', 'bàn giao', 'xây', 'chủ đầu tư', 'cđt'],
      steps: [
        'Dạ em ghi nhận {name} quan tâm pháp lý và tiến độ dự án – đây là điều rất nên tìm hiểu kỹ ạ.',
        'Em có thể gửi mình hồ sơ pháp lý, hình ảnh cập nhật tiến độ thi công mới nhất và mẫu hợp đồng để mình xem trước.',
        '{name} cho em xin số điện thoại/Zalo để em gửi bộ hồ sơ đầy đủ cho mình ạ?',
      ],
      // Khách đọc chậm ở mục có các từ này trên trang -> chủ động hỏi câu dưới.
      browse: {
        keywords: ["pháp lý", "tiến độ", "chủ đầu tư", "sổ hồng", "bàn giao", "giấy phép"],
        question:
          "Dạ phần pháp lý và tiến độ rất nên tìm hiểu kỹ ạ. Em gửi anh/chị bộ hồ sơ pháp lý và hình ảnh thi công mới nhất qua Zalo nhé?",
      },
    },
    {
      label: '📅 Đặt lịch tham quan',
      keywords: ['tham quan', 'xem nhà', 'nhà mẫu', 'lịch', 'đi xem', 'gặp'],
      steps: [
        'Dạ em ghi nhận {name} muốn đi tham quan dự án ạ.',
        'Em có thể đón mình xem nhà mẫu và thực tế dự án vào ngày trong tuần hoặc cuối tuần, em sẽ chuẩn bị sẵn bảng giá các căn còn trống.',
        '{name} cho em xin tên, số điện thoại và thời gian thuận tiện để em giữ lịch cho mình nhé ạ.',
      ],
      // Khách đọc chậm ở mục có các từ này trên trang -> chủ động hỏi câu dưới.
      browse: {
        keywords: ["tham quan", "đăng ký", "nhận thông tin", "nhà mẫu"],
        question:
          "Dạ anh/chị có muốn đi xem thực tế dự án không ạ? Em giữ lịch tham quan cuối tuần này cho mình nhé – anh/chị tiện ngày nào ạ?",
      },
    },
    {
      label: '🏦 Vay ngân hàng',
      keywords: ['vay', 'ngân hàng', 'lãi suất', 'trả góp', 'góp'],
      steps: [
        'Dạ em ghi nhận {name} cần hỗ trợ phương án vay ạ.',
        'Dự án có ngân hàng liên kết hỗ trợ cho vay; em có thể lập bảng tính trả góp hàng tháng theo số tiền vay và thời hạn mình mong muốn.',
        '{name} dự kiến vay khoảng bao nhiêu và trả trong bao lâu ạ? Em tính sẵn dòng tiền cho mình tham khảo.',
      ],
      // Khách đọc chậm ở mục có các từ này trên trang -> chủ động hỏi câu dưới.
      browse: {
        keywords: ["vay", "ngân hàng", "lãi suất", "trả góp", "hỗ trợ tài chính"],
        question:
          "Dạ anh/chị có cần em lập bảng tính trả góp hàng tháng không ạ? Chỉ cần cho em số tiền dự kiến vay là em tính ngay cho mình.",
      },
    },
  ],

  // Chủ động hỏi khi khách đọc chậm ở một mục trên trang (theo dõi cuộn trang).
  proactive: {
    enabled: true,
    dwellSeconds: 8, // dừng đọc ở cùng một mục bao nhiêu giây thì hỏi
    maxPerVisit: 2, // tối đa số lần hỏi chủ động mỗi khách
    quietSeconds: 45, // không chen ngang nếu khách/tư vấn viên vừa nhắn trong khoảng này
  },

  // Mẫu câu cho tư vấn viên (bấm để chèn vào ô chat, sửa được trước khi gửi).
  cannedReplies: [
    {
      step: '1. Dạ ghi nhận',
      items: [
        'Dạ em ghi nhận nhu cầu của {name} rồi ạ.',
        'Dạ vâng, em hiểu ý {name} ạ. Câu hỏi này rất nhiều khách quan tâm.',
        'Dạ em cảm ơn {name} đã chia sẻ, em nắm được mong muốn của mình rồi ạ.',
      ],
    },
    {
      step: '2. Đưa phương án',
      items: [
        'Với nhu cầu của mình, em gợi ý 2 phương án: (1) ... và (2) ... {name} thấy phương án nào phù hợp hơn ạ?',
        'Hiện bên em có chính sách thanh toán theo tiến độ hoặc hỗ trợ vay ngân hàng, em tính giúp mình dòng tiền cụ thể nhé.',
        'Em có sẵn mặt bằng và bảng giá các căn còn trống đúng tầm tài chính của mình ạ.',
      ],
    },
    {
      step: '3. Dẫn dắt xin thông tin',
      items: [
        '{name} cho em xin tên và số điện thoại để em tư vấn sát nhu cầu hơn ạ?',
        '{name} mua để ở hay đầu tư ạ? Ngân sách dự kiến khoảng bao nhiêu để em lọc căn phù hợp?',
        'Gia đình mình mấy người, cần mấy phòng ngủ ạ?',
        '{name} tiện thời gian nào để em gọi trao đổi 5 phút được ạ?',
      ],
    },
  ],
};
