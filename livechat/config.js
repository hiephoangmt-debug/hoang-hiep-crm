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
    hotline: process.env.HOTLINE || '0904 567 009',
    zalo: process.env.ZALO || '0904567009',
    primaryColor: process.env.PRIMARY_COLOR || '#0b2a5b', // xanh navy
    accentColor: process.env.ACCENT_COLOR || '#f47c20', // cam
  },

  // Lời chào: nhẹ nhàng, để khách tự nhiên đọc, không hỏi dồn.
  welcome:
    'Dạ em chào {name}. Em là Hiệp, phụ trách tư vấn dự án {project}. ' +
    'Anh/chị cứ thong thả tham khảo, cần thông tin nào em gửi ngay ạ.',

  // Mời Zalo (chỉ dùng 1 lần, khi khách đã hỏi tới câu thứ 2 hoặc vừa để lại số). Hiện kèm nút "Nhắn Zalo cho em".
  zaloTransfer:
    'Mấy tài liệu như bảng giá từng căn hay mặt bằng chi tiết, anh/chị xem qua Zalo sẽ rõ hơn. ' +
    'Lúc nào tiện, mình nhắn em ở Zalo {zalo} nhé.',

  // Khách vừa để lại số.
  leadThanks:
    'Dạ em cảm ơn {name}. Em sẽ liên hệ qua số {phone} trong ít phút; ' +
    'nếu mình đang bận, em gửi trước tài liệu để anh/chị xem lúc rảnh ạ.',

  // Câu hỏi ngoài các chủ đề có sẵn, khi chưa có tư vấn viên trực tuyến.
  fallback: [
    'Dạ câu này em xin phép kiểm tra lại cho thật chính xác rồi trả lời anh/chị ngay ạ.',
    'Nếu tiện, anh/chị để lại số, em gọi lại nói kỹ hơn vài phút.',
  ],

  // Chủ đề tư vấn. "label" = nút hỏi nhanh; "keywords" = tự nhận diện khi khách tự gõ.
  // steps = [trả lời (dạ ghi nhận + phương án), câu hỏi nhẹ để hiểu nhu cầu].
  // Cách xin thông tin (tự động, không dồn ép): câu hỏi 1 → trả lời + hỏi nhẹ; câu 2 → trả lời + mời Zalo 1 lần;
  // từ câu 3 → trả lời, và hiện form để lại số đúng 1 lần.
  intents: [
    {
      label: 'Chính sách & giá',
      keywords: ['giá', 'gia', 'bao nhiêu', 'chính sách', 'chiết khấu', 'ưu đãi', 'thanh toán', 'tiền', 'thuê lại', 'cam kết thuê', 'cho thuê'],
      steps: [
        'Dạ, để anh/chị dễ hình dung: Parkhome nhận thô từ khoảng 10,4 tỷ (đã trừ chiết khấu 3,5 tỷ); Forestside ven rừng dừa thì giá chênh nhiều theo vị trí từng căn. Hiện cọc 300 triệu, ngân hàng hỗ trợ 70% với 0% lãi trong 24 tháng.',
        'Anh/chị đang để ý biệt thự ven rừng dừa hay biệt thự sân vườn ạ? Em lọc vài căn hợp ý gửi mình xem.',
      ],
      browse: {
        keywords: ['giá', 'bảng giá', 'giá bán', 'chính sách', 'thanh toán', 'ưu đãi', 'chiết khấu'],
        question:
          'Nếu {name} cần, em gửi riêng bảng tính theo từng căn, đã trừ chiết khấu và chia sẵn từng đợt thanh toán, để mình xem cho dễ ạ.',
      },
    },
    {
      label: 'Mặt bằng các căn',
      keywords: ['mặt bằng', 'diện tích', 'loại', 'căn', 'phòng ngủ', 'pn', 'biệt thự', 'shophouse', 'nhà phố', 'layout'],
      steps: [
        'Dạ, bên em có hai dòng chính: Forestside ven sông, giữa rừng dừa, rất riêng tư; và Parkhome có sân vườn, gần công viên, hợp nhà có trẻ nhỏ và ông bà.',
        'Gia đình mình thường về mấy người ạ? Em chọn căn có số phòng vừa vặn để anh/chị xem layout.',
      ],
      browse: {
        keywords: ['mặt bằng', 'sản phẩm', 'loại hình', 'diện tích', 'thiết kế', 'biệt thự', 'layout', 'căn hộ'],
        question:
          'Mặt bằng chính thức và layout từng tầng em có bản đầy đủ. {name} quan tâm dòng nào, em gửi riêng mình tham khảo ạ.',
      },
    },
    {
      label: 'Vị trí & tiện ích',
      keywords: ['vị trí', 'ở đâu', 'đường', 'tiện ích', 'gần', 'trường', 'chợ', 'biển', 'bản đồ', 'clubhouse', 'hồ bơi'],
      steps: [
        'Dạ, dự án nằm ngay rừng dừa Bảy Mẫu, ra phố cổ khoảng 10 phút, ra biển An Bàng khoảng 5 km. Trong khu yên tĩnh, cần đi đâu cũng gần.',
        'Anh/chị đang ở Đà Nẵng hay ở xa ạ? Em gửi thời gian di chuyển cụ thể cho mình.',
      ],
      browse: {
        keywords: ['vị trí', 'tiện ích', 'kết nối', 'bản đồ', 'liên kết vùng', 'ngoại khu', 'nội khu'],
        question:
          'Em có bản đồ khoảng cách thực tế từ từng phân khu ra phố cổ và biển, {name} cần em gửi riêng không ạ?',
      },
    },
    {
      label: 'Pháp lý & bàn giao',
      keywords: ['pháp lý', 'sổ', 'giấy tờ', 'tiến độ', 'bàn giao', 'xây', 'chủ đầu tư', 'cđt', 'đạt phương'],
      steps: [
        'Dạ, phần này anh/chị hỏi rất đúng. Chủ đầu tư là Đạt Phương; em có đủ hồ sơ pháp lý, ảnh tiến độ mới nhất và mẫu hợp đồng để mình tự xem.',
        'Anh/chị muốn xem trước phần sổ hay tiến độ bàn giao ạ?',
      ],
      browse: {
        keywords: ['pháp lý', 'tiến độ', 'chủ đầu tư', 'sổ hồng', 'bàn giao', 'giấy phép', 'minh bạch'],
        question:
          'Bộ hồ sơ pháp lý và hình ảnh thi công mới nhất em có đủ, {name} muốn xem trước phần nào em gửi riêng ạ.',
      },
    },
    {
      label: 'Hẹn xem nhà mẫu',
      keywords: ['tham quan', 'xem nhà', 'nhà mẫu', 'lịch', 'đi xem', 'gặp', 'đón'],
      steps: [
        'Dạ được ạ. Em đón anh/chị ở Đà Nẵng hoặc Hội An, đi xem nhà mẫu và từng phân khu, không ràng buộc gì.',
        'Mình tiện ngày thường hay cuối tuần ạ?',
      ],
      browse: {
        keywords: ['tham quan', 'đăng ký', 'nhận thông tin', 'nhà mẫu', 'tận nơi'],
        question:
          'Nếu {name} muốn xem thực tế, em sắp xếp đón mình vào thời gian thuận tiện, không ràng buộc gì ạ.',
      },
    },
    {
      label: 'Phương án vay',
      keywords: ['vay', 'ngân hàng', 'lãi suất', 'trả góp', 'góp'],
      steps: [
        'Dạ, ngân hàng hỗ trợ tới 70%, 24 tháng đầu lãi 0% và chưa phải trả gốc. Anh/chị chủ động khoảng 30% theo tiến độ là được.',
        'Em lập thử dòng tiền theo một căn cụ thể cho mình xem nhé, anh/chị dự kiến vay khoảng bao nhiêu ạ?',
      ],
      browse: {
        keywords: ['vay', 'ngân hàng', 'lãi suất', 'trả góp', 'hỗ trợ tài chính'],
        question:
          'Em có thể lập bảng dòng tiền theo đúng số anh/chị dự kiến vay, xem trước số tiền từng tháng cho yên tâm ạ.',
      },
    },
  ],

  // Chủ động gợi ý khi khách đọc chậm ở một mục: tối đa 1 lần, không chen ngang.
  proactive: {
    enabled: true,
    dwellSeconds: 12, // dừng đọc ở cùng một mục bao nhiêu giây thì gợi ý
    maxPerVisit: 1, // tối đa số lần gợi ý mỗi khách
    quietSeconds: 60, // không chen ngang nếu khách/tư vấn viên vừa nhắn trong khoảng này
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
