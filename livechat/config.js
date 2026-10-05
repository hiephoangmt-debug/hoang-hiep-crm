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
    'Bảng giá từng căn, mặt bằng và file chính sách gốc xem trên Zalo sẽ rõ hơn nhiều. ' +
    'Khi nào thuận tiện, {name} nhắn em qua Zalo {zalo}, em gửi riêng cho mình ạ.',

  // Khách vừa để lại số.
  leadThanks:
    'Dạ em cảm ơn {name}. Em sẽ liên hệ qua số {phone} trong ít phút; ' +
    'nếu mình đang bận, em gửi trước tài liệu để anh/chị xem lúc rảnh ạ.',

  // Câu hỏi ngoài các chủ đề có sẵn, khi chưa có tư vấn viên trực tuyến.
  fallback: [
    'Dạ câu này em muốn trả lời thật chính xác cho {name}, em kiểm tra lại và phản hồi ngay tại đây ạ.',
    'Nếu tiện, mình để lại số hoặc Zalo, em gửi kèm tài liệu để anh/chị đối chiếu cho dễ.',
  ],

  // Chủ đề tư vấn. "label" = nút hỏi nhanh; "keywords" = tự nhận diện khi khách tự gõ.
  // steps = [trả lời (dạ ghi nhận + phương án), câu hỏi nhẹ để hiểu nhu cầu].
  // Cách xin thông tin (tự động, không dồn ép): câu hỏi 1 → trả lời + hỏi nhẹ; câu 2 → trả lời + mời Zalo 1 lần;
  // từ câu 3 → trả lời, và hiện form để lại số đúng 1 lần.
  intents: [
    {
      label: 'Chính sách & giá',
      keywords: ['giá', 'gia', 'bao nhiêu', 'chính sách', 'chiết khấu', 'ưu đãi', 'thanh toán', 'tiền', 'thuê lại', 'cam kết thuê'],
      steps: [
        'Dạ, chính sách đang áp dụng (ban hành 09/09/2026): đặt cọc 300 triệu, ngân hàng hỗ trợ 70% với lãi suất 0% và ân hạn gốc 24 tháng. Chọn bàn giao thô được chiết khấu tới 4 tỷ (Forestside) hoặc 3,5 tỷ (Parkhome); chủ đầu tư thuê lại 60 triệu/tháng (Forestside) hoặc 50 triệu/tháng (Parkhome) trong 3 năm.',
        'Giá từng căn chênh nhau khá nhiều theo vị trí và phương án bàn giao. {name} đang nghiêng về biệt thự ven rừng dừa hay biệt thự sân vườn ạ?',
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
        'Dạ, dự án có 2 dòng chính: Forestside Villa ven sông, giữa rừng dừa, riêng tư và yên tĩnh; Parkhome là biệt thự sân vườn gần công viên, hợp gia đình có trẻ nhỏ và ông bà. Mỗi căn có vị trí, hướng nhìn và diện tích khác nhau.',
        'Gia đình mình thường về mấy người, để em chọn vài căn có layout vừa vặn nhất ạ?',
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
        'Dạ, dự án nằm giữa rừng dừa Bảy Mẫu (Cẩm Thanh), cách phố cổ khoảng 10 phút, biển An Bàng – Cửa Đại khoảng 5 km, sân bay Đà Nẵng khoảng 30 km. Trong khu có Clubhouse với hồ bơi và gym (đang hoàn thiện nội thất), có ban quản lý vận hành.',
        '{name} đang ở Đà Nẵng hay ở xa ạ? Em gửi lộ trình và thời gian di chuyển cụ thể cho mình.',
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
        'Dạ, đây là phần rất nên tìm hiểu kỹ. Chủ đầu tư là Đạt Phương; em có thể gửi hồ sơ pháp lý, ảnh và video tiến độ thi công mới nhất cùng mẫu hợp đồng để anh/chị tự đối chiếu.',
        '{name} quan tâm nhất phần sở hữu lâu dài hay thời điểm nhận nhà ạ?',
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
        'Dạ, em đón anh/chị tại Đà Nẵng hoặc Hội An, xem nhà mẫu, Clubhouse và từng phân khu, hoàn toàn không ràng buộc. Em chuẩn bị sẵn những căn đang còn để mình xem tận nơi.',
        '{name} thuận tiện ngày trong tuần hay cuối tuần ạ?',
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
        'Dạ, ngân hàng hỗ trợ tới 70%, lãi suất 0% và ân hạn gốc trong 24 tháng; anh/chị chủ động khoảng 30% (cọc, ký hợp đồng và 1 đợt). Không vay thì thanh toán sớm được chiết khấu thêm.',
        'Em tính sẵn dòng tiền từng tháng theo căn cụ thể được, {name} dự kiến vay khoảng bao nhiêu ạ?',
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
