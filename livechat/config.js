// Cấu hình live chat dự án Casamia Balanca.
// Sửa các giá trị bên dưới (hoặc đặt biến môi trường) cho đúng thông tin thực tế.
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
    'Xin chào anh/chị 👋 Em là chuyên viên tư vấn dự án Casamia Balanca. ' +
    'Anh/chị cần em hỗ trợ thông tin gì ạ?',

  // Câu trả lời tự động khi chưa có tư vấn viên trực tuyến.
  offlineReply:
    'Cảm ơn anh/chị đã nhắn tin! Hiện tư vấn viên đang bận, anh/chị vui lòng để lại ' +
    'họ tên và số điện thoại, em sẽ gọi lại ngay ạ.',

  // Nút hỏi nhanh. "reply" là câu trả lời tự động gửi kèm (để trống nếu muốn tư vấn viên tự trả lời).
  quickReplies: [
    { label: '💰 Bảng giá & chính sách', reply: 'Em gửi anh/chị bảng giá và chính sách bán hàng mới nhất ngay ạ. Anh/chị cho em xin số điện thoại/Zalo để gửi file nhé.' },
    { label: '🏠 Mặt bằng & loại sản phẩm', reply: 'Dự án có nhiều loại hình sản phẩm và diện tích. Anh/chị quan tâm loại nào để em gửi mặt bằng chi tiết ạ?' },
    { label: '📍 Vị trí & tiện ích', reply: '' },
    { label: '📅 Đặt lịch tham quan', reply: 'Em xếp lịch tham quan dự án cho anh/chị ạ. Anh/chị cho em xin họ tên, số điện thoại và thời gian thuận tiện nhé.' },
  ],
};
