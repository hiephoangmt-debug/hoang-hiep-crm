/*!
 * fc-widget.js – cụm nút Chat tự động · Zalo · Gọi (góc dưới bên phải) cho mọi website/landing page.
 * Dán trước </body>:
 *   <script src="…/fc-widget.js" data-endpoint="LINK_/exec_CỦA_CRM" defer></script>
 * Tuỳ chọn: data-hotline, data-zalo, data-project, data-drive, data-ai="false", data-teaser="12" (giây; 0 = tắt), data-site.
 * Giao diện nằm trong Shadow DOM nên không bị CSS của trang làm hỏng. File sinh bởi src/build-widget.mjs.
 */
(function () {
  "use strict";
  var me = document.currentScript;
  if (window.__fcwLoaded) { // nạp lần 2 (VD: thẻ trong HTML + mã tuỳ chỉnh có data-endpoint): chỉ nhận thêm đường dẫn CRM
    var ep0 = me && me.getAttribute("data-endpoint");
    if (ep0) { window.__fcwEndpoint = ep0; if (window.__fc) window.__fc.CONFIG.leadEndpoint = ep0; }
    return;
  }
  window.__fcwLoaded = true;
  var A = function (n, d) { return (me && me.getAttribute("data-" + n)) || d; };
  var C = { endpoint: window.__fcwEndpoint || A("endpoint", ""), hotline: A("hotline", "0904 567 009"), zalo: A("zalo", "0904567009"), ai: A("ai", "true") !== "false", teaser: +A("teaser", "12") || 0, site: A("site", "https://www.fpt-city.com") };
  var KB = {"updated":"2026-10-10","projects":[{"name":"FPT Plaza 1","url":"/fpt-plaza-1/","status":"Đã bàn giao · Chuyển nhượng","lead":"Tòa căn hộ đầu tiên của khu đô thị FPT City – cộng đồng cư dân hiện hữu, tiện ích đã vận hành, phù hợp mua ở ngay hoặc cho thuê.","specs":[["Quy mô","1 tầng hầm, 15 tầng nổi"],["Số căn hộ","586 căn"],["Loại căn","1PN, 2PN, 3PN"],["Tình trạng","Đã bàn giao, cư dân đang sinh sống"],["Hình thức","Chuyển nhượng thứ cấp"]],"units":[["1PN","~46 m²"],["2PN","~68 m²"],["3PN","~82 m²"]],"highlights":["Ở ngay – không chờ xây dựng","Dòng tiền cho thuê ổn định từ kỹ sư, giảng viên FPT","Pháp lý rõ ràng, xem nhà thực tế","Giá chuyển nhượng đa dạng theo tầng, hướng"],"faq":[["FPT Plaza 1 bàn giao khi nào?","FPT Plaza 1 đã hoàn thành và bàn giao, hiện có cư dân sinh sống. Giao dịch hiện tại chủ yếu là chuyển nhượng."],["Mua FPT Plaza 1 có xem nhà trực tiếp được không?","Có. Đăng ký để chuyên viên gửi giỏ hàng và đặt lịch xem căn thực tế."]],"hasDrive":false},{"name":"FPT Plaza 2","url":"/fpt-plaza-2/","status":"Đã bàn giao · Chuyển nhượng","lead":"Tòa căn hộ 25 tầng đã bàn giao năm 2023, thiết kế 2–3 phòng ngủ cho gia đình, view sông – biển thoáng đãng.","specs":[["Quy mô","25 tầng nổi, tầng hầm"],["Số căn hộ","~700 căn"],["Loại căn","2PN, 3PN"],["Tình trạng","Đã bàn giao năm 2023"],["Hình thức","Chuyển nhượng thứ cấp"]],"units":[["2PN","~56 – 70 m²"],["3PN","~75 – 90 m²"]],"highlights":["Căn hộ gia đình 2–3PN","Tầng cao view sông Cổ Cò, biển","Nhận nhà ở ngay","Hỗ trợ vay ngân hàng khi chuyển nhượng"],"faq":[["FPT Plaza 2 có bao nhiêu căn?","FPT Plaza 2 có khoảng 700 căn hộ 2–3 phòng ngủ trên 25 tầng nổi."],["Giá FPT Plaza 2 hiện nay thế nào?","Giá chuyển nhượng thay đổi theo tầng, hướng và nội thất. Đăng ký để nhận giỏ hàng cập nhật."]],"hasDrive":false},{"name":"FPT Plaza 3","url":"/fpt-plaza-3/","status":"Hoàn thiện · Bàn giao 2026","lead":"Hai tòa tháp The Empire (E) và The Wealthe (W) cao 25 tầng trên trục Hoàng Minh Thắng, 837 căn hộ cùng khối đế shophouse – tiếp nối thành công của FPT Plaza 1 và 2.","specs":[["Quy mô","2 tòa The Empire (E) & The Wealthe (W) · 2 tầng hầm, 25 tầng nổi"],["Số căn hộ","837 căn + khối đế shophouse"],["Tổng diện tích sàn","~89.278 m²"],["Loại căn","1PN, 2PN, 3PN và các căn +1"],["Vị trí","Đường Hoàng Minh Thắng, khu đô thị FPT City"],["Thi công","Từ Quý I/2024"],["Bàn giao","Dự kiến trong năm 2026 (theo chủ đầu tư)"]],"units":[["1PN","từ ~41,9 m²"],["2PN","~54,6 – 67 m²"],["3PN","~75 – 90 m²"],["3PN+1","~122,8 – 123,5 m²"]],"highlights":["646 căn 2PN (54,6–67 m²) – dòng sản phẩm dễ ở, dễ cho thuê","Khối đế shophouse phục vụ cư dân","Liền kề FPT Plaza 1, 2 – tiện ích sẵn có","Sắp nhận nhà – rút ngắn thời gian chờ"],"faq":[["FPT Plaza 3 khi nào bàn giao?","Chủ đầu tư công bố mốc bàn giao dự kiến trong năm 2026 (thi công từ Quý I/2024). Xem tiến độ thi công cập nhật tại trang tiến độ chính thức hoặc để lại thông tin để nhận lịch bàn giao."],["FPT Plaza 3 có bao nhiêu căn?","Dự án gồm 837 căn hộ trên 2 tòa The Empire (E) và The Wealthe (W), 25 tầng nổi, 2 tầng hầm, cùng khối đế shophouse."],["Căn 2PN FPT Plaza 3 diện tích bao nhiêu?","Có 646 căn 2 phòng ngủ, diện tích khoảng 54,6–67 m², chiếm phần lớn dự án."]],"hasDrive":false},{"name":"FPT Plaza 4","url":"/fpt-plaza-4/","status":"Đang mở bán","lead":"Dự án quy mô lớn nhất chuỗi FPT Plaza: 1.395 căn hộ trên 2 khối N và S, mặt tiền Đại lộ Hoàng Minh Thắng (33m), có vườn trên cao tầng 17, hồ bơi tầng 20 và căn Duplex thông tầng 19–20.","specs":[["Tổng vốn đầu tư","2.790 tỷ đồng"],["Quy mô","2 khối N & S · 3 tầng hầm, 20 tầng nổi"],["Số căn hộ","1.395 căn"],["Mặt tiền","Đại lộ Hoàng Minh Thắng (33m), đường Trần Quốc Vượng, D15, N27"],["Tầng điển hình","Tầng 3–16: 76 căn/tầng"],["Loại căn","1PN, 1PN+, 2PN, 2PN+, 3PN, 3PN+, Duplex 3PN+, Duplex 4PN+"],["Tiện ích nổi bật","Vườn trên cao tầng 17, hồ bơi tầng 20"],["Khởi công","Tháng 3/2025"],["Mở bán","Đủ điều kiện từ 11/2025"],["Bàn giao","Dự kiến Quý II/2027"]],"units":[["1PN / 1PN+","45,5 – 49,8 m²"],["2PN","58,8 – 74,1 m²"],["2PN+","72,6 – 80,4 m²"],["3PN / 3PN+","87,8 – 127,8 m²"],["Duplex 3PN+","142,5 – 172,9 m²"],["Duplex 4PN+","~268,7 m²"]],"highlights":["Đủ điều kiện bán theo xác nhận của Sở Xây dựng","Hơn 80% là căn 2PN – 2PN+ (~59–80 m²) dễ ở, dễ cho thuê","Duplex thông tầng 19–20 tới ~269 m²","Vườn trên cao tầng 17 & hồ bơi tầng 20","Thanh toán theo tiến độ, ngân hàng hỗ trợ vay"],"faq":[["FPT Plaza 4 có những loại căn nào, diện tích bao nhiêu?","Theo mặt bằng tầng: 1PN 46–50 m², 1PN+ 45–50 m², 2PN 59–74 m², 2PN+ 73–80 m², 3PN 88–90 m², 3PN+ 96–128 m², Duplex 3PN+ khoảng 143–173 m² và Duplex 4PN+ khoảng 269 m² (tổng 2 tầng 19–20)."],["Mỗi tầng FPT Plaza 4 có bao nhiêu căn?","Tầng điển hình 3–16 có 76 căn/tầng (khối N 43 căn, khối S 33 căn); tầng 17 và 18 có 72 căn; tầng 19–20 có căn thường và 13 căn Duplex thông tầng."],["Căn Duplex FPT Plaza 4 nằm ở đâu?","Duplex nằm ở tầng 19–20 tại các góc và đầu hồi của 2 khối, gồm 12 căn Duplex 3PN+ và 1 căn Duplex 4PN+ (S-05) – số lượng rất ít."],["Mã căn FPT Plaza 4 đọc thế nào?","Mã căn có dạng Khối-Tầng.Số căn, ví dụ N-07.12 là khối N, tầng 7, căn số 12. Dùng công cụ tra cứu trên trang để xem loại căn và diện tích."],["FPT Plaza 4 bàn giao khi nào?","Dự án khởi công tháng 3/2025, dự kiến bàn giao khoảng Quý II/2027."],["FPT Plaza 4 đã được phép bán chưa?","Tháng 11/2025, Sở Xây dựng Đà Nẵng xác nhận căn hộ FPT Plaza 4 đủ điều kiện bán nhà ở hình thành trong tương lai."]],"hasDrive":true},{"name":"FPT Plaza 5","url":"/fpt-plaza-5/","status":"Sắp mở bán · Nhận đăng ký","lead":"Giai đoạn tiếp theo của chuỗi FPT Plaza. Đăng ký sớm để nhận bảng giá đầu tiên và ưu tiên chọn căn đẹp khi dự án đủ điều kiện mở bán.","specs":[["Quy mô","Dự kiến ~25 tầng nổi, 2 tầng hầm*"],["Số căn hộ","Dự kiến ~830 căn*"],["Loại căn","1PN, 2PN, 3PN"],["Tiến độ","Đang triển khai – chờ thông báo mở bán"],["Hình thức","Sơ cấp từ chủ đầu tư"]],"units":[["1PN","~45 – 50 m²"],["2PN","~56 – 75 m²"],["3PN","từ ~78 m²"]],"highlights":["Giá đợt đầu – dư địa tăng giá","Ưu tiên chọn căn tầng đẹp, view biển","Tiện ích FPT City đã hoàn thiện","Nhận tài liệu & so sánh với FPT Plaza 4"],"faq":[["Giá bán căn hộ FPT Plaza 5 bao nhiêu?","Chủ đầu tư chưa công bố bảng giá chính thức. Khách đăng ký nhận bảng giá tham khảo chuỗi FPT Plaza và được gửi giá FPT Plaza 5 ngay khi có thông tin."],["Khi nào FPT Plaza 5 mở bán?","Thời điểm mở bán phụ thuộc thông báo đủ điều kiện kinh doanh của Sở Xây dựng Đà Nẵng. Đăng ký để được cập nhật sớm nhất."],["FPT Plaza 5 khác gì FPT Plaza 4?","Cùng chủ đầu tư, cùng khu đô thị. FPT Plaza 4 đang mở bán; FPT Plaza 5 là giai đoạn kế tiếp. Bộ tài liệu có bảng so sánh chi tiết."]],"hasDrive":false}],"zones":[{"code":"V1","url":"/dat-nen-fpt-city/phan-khu-v1/","lead":"Phân khu có nhiều lô diện tích lớn, lô góc 2 mặt tiền phù hợp xây biệt thự, nhà vườn.","traits":["Nhiều lô diện tích lớn (200 – 350+ m²)","Lô góc 2 mặt tiền đường nội khu","Phù hợp xây biệt thự, nhà ở gia đình","Hạ tầng hoàn thiện"]},{"code":"V2","url":"/dat-nen-fpt-city/phan-khu-v2/","lead":"Vị trí gần khuôn viên Đại học FPT, nhu cầu thuê nhà từ sinh viên, giảng viên cao quanh năm.","traits":["Gần Đại học FPT & khu ký túc xá","Lô phổ biến ~100 m²","Phù hợp xây nhà cho thuê, căn hộ dịch vụ","Thanh khoản tốt"]},{"code":"V3","url":"/dat-nen-fpt-city/phan-khu-v3/","lead":"Khu dân cư đã hình thành, nhiều nhà xây hoàn thiện – phù hợp ở thực và kinh doanh nhỏ.","traits":["Dân cư hiện hữu đông","Lô phổ biến ~100 m²","Gần trường học & tiện ích nội khu","Phù hợp ở thực, kinh doanh"]},{"code":"V4","url":"/dat-nen-fpt-city/phan-khu-v4/","lead":"Phân khu nằm trong tổng thể quy hoạch đồng bộ của FPT City; giỏ hàng cập nhật theo tuần.","traits":["Quy hoạch đồng bộ, đường nội khu rộng","Nhiều lựa chọn diện tích","Pháp lý sổ đỏ từng lô","Giỏ hàng cập nhật hằng tuần"]},{"code":"V5","url":"/dat-nen-fpt-city/phan-khu-v5/","lead":"Phân khu được giao dịch sôi động với lô diện tích vừa phải, tổng tiền dễ tiếp cận.","traits":["Lô phổ biến 90 – 105 m²","Tổng tiền dễ tiếp cận","Giao dịch sôi động, thanh khoản cao","Phù hợp xây nhà ở & cho thuê"]},{"code":"V6","url":"/dat-nen-fpt-city/phan-khu-v6/","lead":"Vị trí gần tổ hợp văn phòng FPT Complex và trục đường Nam Kỳ Khởi Nghĩa – nguồn khách thuê là kỹ sư công nghệ.","traits":["Gần FPT Complex – hàng nghìn kỹ sư","Sát trục Nam Kỳ Khởi Nghĩa","Có lô view kênh sinh thái","Tiềm năng kinh doanh, cho thuê"]}],"city":{"name":"Khu đô thị FPT City Đà Nẵng","investor":"Công ty Cổ phần Đô thị FPT Đà Nẵng (FPT City) – thành viên Tập đoàn FPT","area":"hơn 181 ha","capital":"khoảng 952 triệu USD (dự kiến)","location":"Phía Nam TP. Đà Nẵng: ~5 phút tới biển Tân Trà – Non Nước, ~15–20 phút tới trung tâm, ~20 phút tới sân bay và phố cổ Hội An.","amenities":"Đại học FPT & hệ thống trường FPT, FPT Complex, công viên – kênh sinh thái, hồ bơi, gym, shophouse, siêu thị."},"fp4":{"floors":[{"id":"3-16","from":3,"to":16},{"id":"17","from":17,"to":17},{"id":"18","from":18,"to":18},{"id":"19","from":19,"to":19},{"id":"20","from":20,"to":20}],"units":[["3-16","N","10","2PN",69.83],["3-16","N","11","2PN",69.56],["3-16","N","12","3PN",87.85],["3-16","N","14","2PN",72.17],["3-16","N","15","2PN",69.49],["3-16","N","16","2PN",69.42],["3-16","N","17","1PN",46.27],["3-16","N","18","3PN+",127.77],["3-16","N","19","2PN",69.69],["3-16","N","20","2PN",69.54],["3-16","N","21","2PN",69.05],["3-16","N","22","2PN",68.5],["3-16","N","23","1PN+",45.49],["3-16","N","24","2PN",59.13],["3-16","N","25","2PN+",73.1],["3-16","N","26","2PN",70.11],["3-16","N","27","2PN",70.06],["3-16","N","28","2PN+",73],["3-16","N","29","2PN",60.17],["3-16","N","30","1PN+",45.7],["3-16","N","31","2PN",72.63],["3-16","N","32","2PN",69.58],["3-16","N","33","2PN",69.15],["3-16","N","34","2PN",66.75],["3-16","N","35","2PN+",80.03],["3-16","N","36","3PN",89.82],["3-16","N","37","2PN",71.06],["3-16","N","38","2PN",69.68],["3-16","N","39","2PN",69.7],["3-16","N","40","2PN",74.13],["3-16","N","41","2PN",68.58],["3-16","N","42","2PN+",77.39],["3-16","N","43","2PN+",77.46],["3-16","N","01","2PN",66.66],["3-16","N","02","2PN",69.78],["3-16","N","03","2PN",69.28],["3-16","N","04","2PN",69.34],["3-16","N","05","2PN",69.74],["3-16","N","06","2PN+",79.03],["3-16","N","07","2PN",69.34],["3-16","N","08","2PN",69.74],["3-16","N","09","2PN",69.49],["3-16","N","12A","3PN",90.31],["3-16","S","10","2PN",69.74],["3-16","S","11","2PN",67.49],["3-16","S","12","2PN",60.66],["3-16","S","14","2PN",70.27],["3-16","S","15","2PN",70.34],["3-16","S","16","2PN+",72.98],["3-16","S","17","2PN",59.66],["3-16","S","18","2PN",64.93],["3-16","S","19","2PN",72.47],["3-16","S","20","2PN",69.72],["3-16","S","21","2PN",70.26],["3-16","S","22","2PN",69.68],["3-16","S","23","2PN",69.44],["3-16","S","24","3PN",87.84],["3-16","S","25","2PN+",76.16],["3-16","S","26","2PN",69.89],["3-16","S","27","2PN",69.91],["3-16","S","28","3PN+",118.4],["3-16","S","29","2PN",70.59],["3-16","S","30","2PN",68.5],["3-16","S","31","2PN",58.76],["3-16","S","32","2PN+",77.46],["3-16","S","33","2PN+",77.37],["3-16","S","01","2PN",58.78],["3-16","S","02","1PN+",49.53],["3-16","S","03","2PN",70.03],["3-16","S","04","2PN",69.76],["3-16","S","05","2PN",69.83],["3-16","S","06","2PN+",80.38],["3-16","S","07","3PN+",96.03],["3-16","S","08","1PN",49.76],["3-16","S","09","2PN",69.46],["3-16","S","12A","2PN+",72.86],["17","N","10","2PN",69.83],["17","N","11","2PN",69.56],["17","N","12","3PN",87.85],["17","N","14","2PN",72.17],["17","N","15","2PN",69.49],["17","N","16","2PN",69.42],["17","N","17","1PN",46.27],["17","N","18","3PN+",127.77],["17","N","19","2PN",69.69],["17","N","20","2PN",69.54],["17","N","21","2PN",69.05],["17","N","22","2PN",68.5],["17","N","23","1PN+",45.49],["17","N","24","2PN",59.13],["17","N","25","2PN",70.67],["17","N","26","2PN",70.57],["17","N","27","2PN",60.3],["17","N","28","1PN+",45.7],["17","N","29","2PN",72.63],["17","N","30","2PN",69.58],["17","N","31","2PN",69.15],["17","N","32","2PN",66.75],["17","N","33","2PN+",80.03],["17","N","34","3PN",89.82],["17","N","35","2PN",71.06],["17","N","36","2PN",69.68],["17","N","37","2PN",69.7],["17","N","38","2PN",74.13],["17","N","39","2PN",68.58],["17","N","40","2PN+",77.39],["17","N","41","2PN+",77.46],["17","N","01","2PN",66.66],["17","N","02","2PN",69.78],["17","N","03","2PN",69.28],["17","N","04","2PN",69.34],["17","N","05","2PN",69.74],["17","N","06","2PN+",79.03],["17","N","07","2PN",69.34],["17","N","08","2PN",69.74],["17","N","09","2PN",69.49],["17","N","12A","3PN",90.31],["17","S","10","2PN",69.74],["17","S","11","2PN",67.49],["17","S","12","2PN",60.66],["17","S","14","2PN+",72.71],["17","S","15","2PN",59.66],["17","S","16","2PN",64.93],["17","S","17","2PN",72.47],["17","S","18","2PN",69.72],["17","S","19","2PN",70.26],["17","S","20","2PN",69.68],["17","S","21","2PN",69.44],["17","S","22","3PN",87.84],["17","S","23","2PN+",76.16],["17","S","24","2PN",69.89],["17","S","25","2PN",69.91],["17","S","26","3PN+",118.4],["17","S","27","2PN",70.59],["17","S","28","2PN",68.5],["17","S","29","2PN",58.76],["17","S","30","2PN+",77.46],["17","S","31","2PN+",77.37],["17","S","01","2PN",58.78],["17","S","02","1PN+",49.53],["17","S","03","2PN",70.03],["17","S","04","2PN",69.76],["17","S","05","2PN",69.83],["17","S","06","2PN+",80.38],["17","S","07","3PN+",96.03],["17","S","08","1PN",49.76],["17","S","09","2PN",69.46],["17","S","12A","2PN+",72.59],["18","N","10","2PN",69.83],["18","N","11","2PN",69.56],["18","N","12","3PN",87.85],["18","N","14","2PN",72.17],["18","N","15","2PN",69.49],["18","N","16","2PN",69.42],["18","N","17","1PN",46.27],["18","N","18","3PN+",127.77],["18","N","19","2PN",69.69],["18","N","20","2PN",69.54],["18","N","21","2PN",69.05],["18","N","22","2PN",68.5],["18","N","23","1PN+",45.49],["18","N","24","2PN",59.13],["18","N","25","2PN",70.67],["18","N","26","2PN",70.57],["18","N","27","2PN",60.3],["18","N","28","1PN+",45.7],["18","N","29","2PN",72.63],["18","N","30","2PN",69.58],["18","N","31","2PN",69.15],["18","N","32","2PN",66.75],["18","N","33","2PN+",80.03],["18","N","34","3PN",89.82],["18","N","35","2PN",71.06],["18","N","36","2PN",69.68],["18","N","37","2PN",69.7],["18","N","38","2PN",74.13],["18","N","39","2PN",68.58],["18","N","40","2PN+",77.39],["18","N","41","2PN+",77.46],["18","N","01","2PN",66.66],["18","N","02","2PN",69.78],["18","N","03","2PN",69.28],["18","N","04","2PN",69.34],["18","N","05","2PN",69.74],["18","N","06","2PN+",79.03],["18","N","07","2PN",69.34],["18","N","08","2PN",69.74],["18","N","09","2PN",69.49],["18","N","12A","3PN",90.31],["18","S","10","2PN",69.74],["18","S","11","2PN",67.49],["18","S","12","2PN",60.66],["18","S","14","2PN+",72.71],["18","S","15","2PN",59.66],["18","S","16","2PN",64.93],["18","S","17","2PN",72.47],["18","S","18","2PN",69.72],["18","S","19","2PN",70.26],["18","S","20","2PN",69.68],["18","S","21","2PN",69.44],["18","S","22","3PN",87.84],["18","S","23","2PN+",76.16],["18","S","24","2PN",69.89],["18","S","25","2PN",69.91],["18","S","26","3PN+",118.4],["18","S","27","2PN",70.59],["18","S","28","2PN",68.5],["18","S","29","2PN",58.76],["18","S","30","2PN+",77.46],["18","S","31","2PN+",77.37],["18","S","01","2PN",58.78],["18","S","02","1PN+",49.53],["18","S","03","2PN",70.03],["18","S","04","2PN",69.76],["18","S","05","2PN",69.83],["18","S","06","2PN+",80.38],["18","S","07","3PN+",96.03],["18","S","08","1PN",49.76],["18","S","09","2PN",69.46],["18","S","12A","2PN+",72.59],["19","N","10","2PN",69.83],["19","N","11","2PN",69.56],["19","N","12","DUP-3PN+",92.49],["19","N","14","2PN",72.17],["19","N","15","2PN",69.49],["19","N","16","2PN",69.42],["19","N","17","1PN",46.27],["19","N","18","3PN+",127.77],["19","N","19","2PN",69.69],["19","N","20","2PN",69.54],["19","N","21","2PN",69.05],["19","N","22","2PN",68.5],["19","N","23","1PN+",45.49],["19","N","24","2PN",59.13],["19","N","25","DUP-3PN+",84.95],["19","N","26","DUP-3PN+",84.86],["19","N","27","2PN",60.3],["19","N","28","1PN+",45.7],["19","N","29","2PN",72.63],["19","N","30","2PN",69.58],["19","N","31","2PN",69.15],["19","N","32","2PN",66.75],["19","N","33","DUP-3PN+",85.09],["19","N","34","DUP-3PN+",95.88],["19","N","35","2PN",71.07],["19","N","36","2PN",69.68],["19","N","37","2PN",69.7],["19","N","38","2PN",74.13],["19","N","39","2PN",68.58],["19","N","40","2PN+",77.39],["19","N","41","2PN+",77.46],["19","N","01","2PN",66.66],["19","N","02","2PN",69.78],["19","N","03","2PN",69.28],["19","N","04","2PN",69.34],["19","N","05","2PN",69.74],["19","N","06","2PN+",79.03],["19","N","07","2PN",69.34],["19","N","08","2PN",69.74],["19","N","09","2PN",69.49],["19","N","12A","DUP-3PN+",99.94],["19","S","10","2PN",67.49],["19","S","11","2PN",60.66],["19","S","12","DUP-3PN+",86.96],["19","S","14","2PN",59.66],["19","S","15","2PN",64.93],["19","S","16","2PN",72.47],["19","S","17","2PN",69.72],["19","S","18","DUP-3PN+",81.78],["19","S","19","2PN",69.68],["19","S","20","2PN",69.44],["19","S","21","DUP-3PN+",96.06],["19","S","22","DUP-3PN+",81.73],["19","S","23","2PN",69.89],["19","S","24","2PN",69.91],["19","S","25","3PN+",118.4],["19","S","26","2PN",70.59],["19","S","27","2PN",68.5],["19","S","28","2PN",58.76],["19","S","29","2PN+",77.46],["19","S","30","2PN+",77.37],["19","S","01","2PN",58.78],["19","S","02","1PN+",49.53],["19","S","03","2PN",70.03],["19","S","04","2PN",69.76],["19","S","05","DUP-4PN+",156.29],["19","S","06","DUP-3PN+",81.92],["19","S","07","2PN",66.47],["19","S","08","2PN",69.46],["19","S","09","2PN",69.74],["19","S","12A","DUP-3PN+",86.89],["20","N","10","2PN",69.83],["20","N","11","2PN",69.56],["20","N","12","DUP-3PN+",67.65],["20","N","14","2PN",72.17],["20","N","15","2PN",69.49],["20","N","16","2PN",69.42],["20","N","17","1PN",46.27],["20","N","18","3PN+",127.77],["20","N","19","2PN",69.69],["20","N","20","2PN",69.54],["20","N","21","2PN",69.05],["20","N","22","2PN",68.5],["20","N","23","1PN+",45.49],["20","N","24","2PN",59.13],["20","N","25","DUP-3PN+",61.83],["20","N","26","DUP-3PN+",61.71],["20","N","27","2PN",60.3],["20","N","28","1PN+",45.7],["20","N","29","2PN",72.63],["20","N","30","2PN",69.58],["20","N","31","2PN",69.15],["20","N","32","2PN",66.75],["20","N","33","DUP-3PN+",69.11],["20","N","34","DUP-3PN+",75.36],["20","N","35","2PN",71.07],["20","N","36","2PN",69.68],["20","N","37","2PN",69.7],["20","N","38","2PN",74.13],["20","N","39","2PN",68.58],["20","N","40","2PN+",77.39],["20","N","41","2PN+",77.46],["20","N","01","2PN",66.66],["20","N","02","2PN",69.78],["20","N","03","2PN",69.28],["20","N","04","2PN",69.34],["20","N","05","2PN",69.74],["20","N","06","2PN+",79.03],["20","N","07","2PN",69.34],["20","N","08","2PN",69.74],["20","N","09","2PN",69.49],["20","N","12A","DUP-3PN+",72.92],["20","S","10","2PN",67.49],["20","S","11","2PN",60.66],["20","S","12","DUP-3PN+",63.84],["20","S","14","2PN",59.66],["20","S","15","2PN",64.93],["20","S","16","2PN",72.47],["20","S","17","2PN",69.72],["20","S","18","DUP-3PN+",60.75],["20","S","19","2PN",69.68],["20","S","20","2PN",69.44],["20","S","21","DUP-3PN+",65.29],["20","S","22","DUP-3PN+",64.85],["20","S","23","2PN",69.89],["20","S","24","2PN",69.91],["20","S","25","3PN+",118.4],["20","S","26","2PN",70.59],["20","S","27","2PN",68.5],["20","S","28","2PN",58.76],["20","S","29","2PN+",77.46],["20","S","30","2PN+",77.37],["20","S","01","2PN",58.78],["20","S","02","1PN+",49.53],["20","S","03","2PN",70.03],["20","S","04","2PN",69.76],["20","S","05","DUP-4PN+",112.44],["20","S","06","DUP-3PN+",64.54],["20","S","07","2PN",66.53],["20","S","08","2PN",69.46],["20","S","09","2PN",69.74],["20","S","12A","DUP-3PN+",63.75]],"types":{"1PN":"Căn hộ 1 PN","1PN+":"Căn hộ 1 PN+","2PN":"Căn hộ 2 PN","2PN+":"Căn hộ 2 PN+","3PN":"Căn hộ 3 PN","3PN+":"Căn hộ 3 PN+","DUP-3PN+":"Duplex 3 PN+","DUP-4PN+":"Duplex 4 PN+"},"layouts":[{"img":"/assets/img/fpt-plaza-4/layout/layout-fpt-plaza-4-n-06.webp","units":[["N","06",3,20]],"area":79.03},{"img":"/assets/img/fpt-plaza-4/layout/layout-fpt-plaza-4-n-11.webp","units":[["N","11",3,20]],"area":69.56},{"img":"/assets/img/fpt-plaza-4/layout/layout-fpt-plaza-4-n-20.webp","units":[["N","20",3,20]],"area":69.54},{"img":"/assets/img/fpt-plaza-4/layout/layout-fpt-plaza-4-n-29-n-27.webp","units":[["N","29",3,16],["N","27",17,20]],"area":60.17},{"img":"/assets/img/fpt-plaza-4/layout/layout-fpt-plaza-4-s-01.webp","units":[["S","01",3,20]],"area":58.78}]}};
  var DRIVES = {"FPT Plaza 4":"https://drive.google.com/drive/folders/1Kd_kJYOkwz8eV5D2eYalKlrqgVymEDYB"};
  var IMG = "https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/5051b81aefcfec407044094b96b5dfc7fdd47de8/website/public/assets/img/";
  var CSS = ":host { all: initial; --navy-900:#0a1630; --navy-800:#0f2350; --navy-700:#16306b; --navy-500:#2453b3; --navy-100:#eef3fb; --orange:#ff8a1f; --orange-600:#f26a0f; --orange-700:#d4560b; --ink:#0f1b33; --muted:#5a6782; --line:#dfe5f0; font-family: \"Be Vietnam Pro\", system-ui, -apple-system, \"Segoe UI\", Roboto, sans-serif; font-size: 16px; line-height: 1.5; color: #0f1b33; }\n*, *::before, *::after { box-sizing: border-box; }\n[hidden] { display: none !important; }\na { color: inherit; }\nbutton, input { font: inherit; }\n.floating { position: fixed; right: 18px; bottom: 24px; display: grid; gap: 12px; z-index: 2147483000; justify-items: end; }\n.fab { position: relative; width: 56px; height: 56px; border-radius: 50%; display: grid; place-items: center; text-decoration: none; font-weight: 800; font-size: 14px; box-shadow: 0 10px 24px rgba(0,0,0,.25); border: 0; cursor: pointer; padding: 0; }\n.fab-call { background: #e4572e; color: #fff; font-size: 22px; animation: ring 1.8s infinite; }\n.fab-zalo { background: #0068ff; color: #fff; }\n.fab-chat { background: linear-gradient(135deg, var(--orange), var(--orange-600)); color: var(--navy-900); width: 62px; height: 62px; }\n.fab-chat::before { content: \"\"; position: absolute; inset: -6px; border-radius: 50%; border: 2px solid var(--orange); opacity: .6; animation: halo 2s ease-out infinite; }\n.fab-badge { position: absolute; top: -2px; right: -2px; min-width: 20px; height: 20px; border-radius: 10px; background: #e4572e; color: #fff; font-size: 12px; display: grid; place-items: center; border: 2px solid #fff; }\n.fab-label { position: absolute; right: calc(100% + 10px); top: 50%; transform: translateY(-50%); background: var(--navy-900); color: #fff; font-size: 13px; font-weight: 700; padding: 6px 10px; border-radius: 8px; white-space: nowrap; opacity: 0; pointer-events: none; transition: opacity .2s; }\n.fab:hover .fab-label, .fab:focus-visible .fab-label { opacity: 1; }\n.fab:focus-visible, .act:focus-visible, .chat-chips button:focus-visible, .chat-form button:focus-visible { outline: 3px solid var(--orange); outline-offset: 2px; }\n@keyframes ring { 0%, 50%, 100% { transform: rotate(0); } 10%, 30% { transform: rotate(-12deg); } 20%, 40% { transform: rotate(12deg); } }\n@keyframes halo { 0% { transform: scale(.9); opacity: .7; } 100% { transform: scale(1.35); opacity: 0; } }\n.chat-teaser { position: fixed; right: 92px; bottom: 150px; z-index: 2147483001; max-width: 250px; background: #fff; color: var(--ink); padding: 12px 30px 12px 14px; border-radius: 14px 14px 4px 14px; box-shadow: 0 18px 50px -20px rgba(10,22,48,.45); font-size: 14px; font-weight: 600; cursor: pointer; border: 1px solid var(--line); animation: pop .3s ease-out; }\n.chat-teaser-x { position: absolute; top: 4px; right: 6px; border: 0; background: none; font-size: 18px; color: var(--muted); cursor: pointer; line-height: 1; }\n@keyframes pop { from { transform: translateY(8px) scale(.96); opacity: 0; } to { transform: none; opacity: 1; } }\n.chatbox { position: fixed; right: 18px; bottom: 96px; z-index: 2147483002; width: min(380px, calc(100vw - 24px)); height: min(580px, calc(100vh - 120px)); background: #fff; border-radius: 20px; box-shadow: 0 30px 80px -20px rgba(10,22,48,.5); display: flex; flex-direction: column; overflow: hidden; border: 1px solid var(--line); animation: pop .25s ease-out; }\n.chat-head { display: flex; align-items: center; gap: 10px; padding: 14px 16px; background: linear-gradient(135deg, var(--navy-900), var(--navy-700)); color: #fff; }\n.chat-head b { display: block; font-size: 15px; }\n.chat-head small { font-size: 12px; opacity: .8; display: flex; align-items: center; gap: 6px; }\n.chat-head .dot { width: 8px; height: 8px; border-radius: 50%; background: #3ddc84; display: inline-block; }\n.chat-ava { width: 38px; height: 38px; border-radius: 50%; background: rgba(255,255,255,.12); display: grid; place-items: center; font-size: 20px; }\n.chat-x { margin-left: auto; border: 0; background: none; color: #fff; font-size: 26px; cursor: pointer; line-height: 1; }\n.chat-log { flex: 1; overflow-y: auto; padding: 16px 14px; display: flex; flex-direction: column; gap: 10px; background: var(--navy-100); }\n.msg { display: flex; flex-direction: column; max-width: 86%; }\n.msg.bot { align-self: flex-start; }\n.msg.me { align-self: flex-end; align-items: flex-end; }\n.bubble { padding: 10px 13px; border-radius: 16px; font-size: 14px; line-height: 1.5; word-wrap: break-word; }\n.msg.bot .bubble { background: #fff; border-bottom-left-radius: 4px; box-shadow: 0 2px 6px rgba(10,22,48,.06); }\n.msg.me .bubble { background: var(--navy-800); color: #fff; border-bottom-right-radius: 4px; }\n.bubble a { color: var(--navy-500); font-weight: 700; }\n.msg-actions { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }\n.act { border: 1px solid var(--line); background: #fff; color: var(--navy-800); border-radius: 999px; padding: 6px 12px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; }\n.act.primary { background: var(--orange); border-color: var(--orange); color: var(--navy-900); }\n.typing .bubble { display: flex; gap: 4px; padding: 14px; }\n.typing i { width: 7px; height: 7px; border-radius: 50%; background: var(--muted); animation: blink 1.2s infinite; }\n.typing i:nth-child(2) { animation-delay: .2s; } .typing i:nth-child(3) { animation-delay: .4s; }\n@keyframes blink { 0%, 80%, 100% { opacity: .3; } 40% { opacity: 1; } }\n.chat-chips { display: flex; gap: 6px; overflow-x: auto; padding: 8px 12px; background: #fff; border-top: 1px solid var(--line); scrollbar-width: none; }\n.chat-chips:empty { display: none; }\n.chat-chips button { flex: 0 0 auto; border: 1px solid var(--orange); background: #fff7ef; color: var(--orange-700); border-radius: 999px; padding: 6px 12px; font-size: 13px; font-weight: 700; cursor: pointer; }\n.chat-form { display: flex; gap: 8px; padding: 10px 12px; border-top: 1px solid var(--line); background: #fff; }\n.chat-form input { flex: 1; min-width: 0; border: 1.5px solid var(--line); border-radius: 999px; padding: 10px 14px; font-size: 16px; color: var(--ink); background: #fff; }\n.chat-form input:focus { outline: none; border-color: var(--navy-500); }\n.chat-form button { width: 42px; height: 42px; border-radius: 50%; border: 0; background: var(--navy-800); color: var(--orange); font-size: 16px; cursor: pointer; }\n.chat-note { margin: 0; padding: 0 12px 8px; font-size: 11px; color: var(--muted); text-align: center; background: #fff; }\n@media (max-width: 640px) {\n  .floating { right: 12px; bottom: 16px; gap: 10px; }\n  .fab { width: 50px; height: 50px; }\n  .fab-chat { width: 56px; height: 56px; }\n  .fab-label { display: none; }\n  .chat-teaser { right: 76px; bottom: 120px; }\n  .chatbox { right: 0; left: 0; bottom: 0; width: 100%; height: min(88vh, 640px); border-radius: 20px 20px 0 0; }\n}\n@media (prefers-reduced-motion: reduce) { .fab-call, .fab-chat::before, .chat-teaser, .chatbox, .typing i { animation: none; } }\n";
  var HTML = "\n<div class=\"floating\" aria-label=\"Liên hệ nhanh\">\n  <button type=\"button\" class=\"fab fab-chat\" data-chat-open aria-label=\"Chat tư vấn tự động\" aria-expanded=\"false\" aria-controls=\"chatbox\">\n    <svg width=\"26\" height=\"26\" viewBox=\"0 0 24 24\" aria-hidden=\"true\"><path fill=\"currentColor\" d=\"M12 3C6.5 3 2 6.6 2 11c0 2.4 1.3 4.5 3.4 6l-.9 3.6c-.1.4.3.7.7.5L9.3 19c.9.2 1.8.3 2.7.3 5.5 0 10-3.6 10-8.1S17.5 3 12 3Zm-4 9.3a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6Zm4 0a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6Zm4 0a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6Z\"/></svg>\n    <span class=\"fab-badge\" data-chat-badge>1</span><span class=\"fab-label\">Chat tư vấn 24/7</span>\n  </button>\n  <a href=\"#\" class=\"fab fab-zalo\" data-zalo-link target=\"_blank\" rel=\"noopener\" aria-label=\"Chat Zalo\">Zalo<span class=\"fab-label\">Nhắn Zalo</span></a>\n  <a href=\"tel:\" class=\"fab fab-call\" data-hotline-link aria-label=\"Gọi hotline\">📞<span class=\"fab-label\" data-hotline></span></a>\n</div>\n<div class=\"chat-teaser\" data-chat-teaser hidden><button type=\"button\" class=\"chat-teaser-x\" aria-label=\"Ẩn\" data-teaser-close>×</button><span data-chat-open>👋 Bạn cần bảng giá hay mặt bằng căn hộ? Hỏi mình nhé!</span></div>\n<section class=\"chatbox\" id=\"chatbox\" role=\"dialog\" aria-label=\"Chat tư vấn tự động\" hidden>\n  <header class=\"chat-head\"><span class=\"chat-ava\" aria-hidden=\"true\">🤖</span><div><b>Trợ lý FPT City</b><small><i class=\"dot\"></i>Trả lời tự động ngay lập tức</small></div><button type=\"button\" class=\"chat-x\" data-chat-close aria-label=\"Đóng chat\">×</button></header>\n  <div class=\"chat-log\" data-chat-log aria-live=\"polite\"></div>\n  <div class=\"chat-chips\" data-chat-chips></div>\n  <form class=\"chat-form\" data-chat-form autocomplete=\"off\"><input name=\"q\" maxlength=\"400\" placeholder=\"Nhập câu hỏi hoặc mã căn (VD: N-12.12)…\" aria-label=\"Nội dung chat\"><button type=\"submit\" aria-label=\"Gửi\">➤</button></form>\n  <p class=\"chat-note\">Trợ lý tự động · Thông tin tham khảo, giá chính xác do chuyên viên gửi</p>\n</section>";

  function project() {
    var p = location.pathname.toLowerCase(), m;
    if (A("project", "")) return A("project", "");
    if ((m = p.match(/fpt-plaza-?(\d)/))) return "FPT Plaza " + m[1];
    if ((m = p.match(/phan-khu-v(\d)/))) return "Đất nền FPT City V" + m[1];
    if (/dat-nen/.test(p)) return "Đất nền FPT City";
    if (/fpt-city\.com$/.test(location.hostname)) return "FPT City";
    return location.hostname.replace(/^www\./, "");
  }
  var PROJECT = project();
  var DRIVE = A("drive", "") || DRIVES[PROJECT] || "";
  var tel = C.hotline.replace(/[^\d+]/g, "");

  var ss = {
    get: function (k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
    set: function (k, v) { try { sessionStorage.setItem(k, v); } catch (e) { /* bỏ qua */ } },
  };
  var KEYS = ["utm_source", "utm_medium", "utm_campaign", "utm_term", "utm_content", "gclid", "fbclid"];
  var utm = {};
  try { utm = JSON.parse(ss.get("hh_utm") || "{}"); } catch (e) { utm = {}; }
  var qs = new URLSearchParams(location.search);
  KEYS.forEach(function (k) { if (qs.get(k)) utm[k] = qs.get(k); });
  if (!utm.referrer && document.referrer && document.referrer.indexOf(location.hostname) < 0) utm.referrer = document.referrer;
  ss.set("hh_utm", JSON.stringify(utm));

  function getIp() {
    return new Promise(function (resolve) {
      var t = setTimeout(function () { resolve(""); }, 1500);
      try {
        fetch("https://api.ipify.org?format=json").then(function (r) { return r.json(); }).then(function (d) { clearTimeout(t); resolve(d.ip || ""); }).catch(function () { clearTimeout(t); resolve(""); });
      } catch (e) { clearTimeout(t); resolve(""); }
    });
  }
  function track(event, props) {
    try {
      if (window.dataLayer) window.dataLayer.push(Object.assign({ event: event }, props));
      if (window.gtag) window.gtag("event", event, props);
      if (window.fbq && event === "generate_lead") window.fbq("track", "Lead", props);
    } catch (e) { /* bỏ qua */ }
  }
  function fix(h) {
    if (!h) return h;
    if (h.indexOf("/assets/img/") === 0) return IMG + h.slice("/assets/img/".length);
    if (h.charAt(0) === "/") return C.site + h.replace(/\/(?=#|$)/, "");
    return h;
  }

  function mount() {
    document.querySelectorAll(".fabs").forEach(function (e) { e.remove(); }); // bỏ nút Zalo/Gọi tĩnh của trang (widget thay thế)
    setTimeout(function () { document.querySelectorAll(".fabs").forEach(function (e) { e.remove(); }); }, 1500);

    var host = document.createElement("div");
    host.id = "fc-widget";
    document.body.appendChild(host);
    var root = host.attachShadow({ mode: "open" });
    root.innerHTML = "<style>" + CSS + "</style>" + HTML;
    root.querySelectorAll("[data-hotline-link]").forEach(function (a) { a.href = "tel:" + tel; });
    root.querySelectorAll("[data-hotline]").forEach(function (s) { s.textContent = C.hotline; });
    root.querySelectorAll("[data-zalo-link]").forEach(function (a) { a.href = "https://zalo.me/" + C.zalo.replace(/\D/g, ""); });
    window.__fcRoot = root;

    window.__fc = {
      CONFIG: { leadEndpoint: window.__fcwEndpoint || C.endpoint, chatAI: C.ai, chatTeaserSeconds: C.teaser },
      project: PROJECT, hasDrive: /^https:\/\/drive\.google\.com\//.test(DRIVE), drive: DRIVE, kb: KB, fix: fix, track: track,
      openForm: function (unit) {
        var closer = root.querySelector("[data-chat-close]"); if (closer) closer.click();
        var code = (String(unit || "").match(/[NS]-\d{2}\.\d{1,2}A?/) || [])[0];
        var field = document.querySelector('input[name="unit"]');
        if (field && code) field.value = code;
        var target = document.getElementById("dang-ky") || document.querySelector("form");
        if (!target) { window.open("https://zalo.me/" + C.zalo.replace(/\D/g, ""), "_blank"); return; }
        target.scrollIntoView({ behavior: "smooth", block: "center" });
        var first = target.querySelector("input");
        setTimeout(function () { if (first) try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); } }, 700);
      },
      sendLead: function (fields) {
        var data = Object.assign({ email: "", need: "", project: PROJECT, page: location.href, referrer: document.referrer, time: new Date().toISOString() }, utm, fields);
        track("generate_lead", { form: data.source, need: data.need, project: data.project });
        var ep = window.__fc.CONFIG.leadEndpoint;
        if (!ep) return Promise.resolve();
        return getIp().then(function (ip) {
          data.ip = ip;
          var body = new URLSearchParams(data);
          try { if (navigator.sendBeacon && navigator.sendBeacon(ep, body)) return; } catch (e) { /* thử fetch */ }
          return fetch(ep, { method: "POST", mode: "no-cors", keepalive: true, body: body });
        });
      },
    };
/* =========================================================
   Chat tư vấn tự động – FPT City
   - Trả lời ngay từ kho kiến thức /assets/chat-kb.json (sinh lúc build)
   - Tra mã căn FPT Plaza 4 (VD: N-12.12, S 19.05)
   - Khách gõ SĐT → gửi lead về CRM
   - Tuỳ chọn: câu hỏi khác chuyển cho AI qua CRM (CONFIG.chatAI)
   ========================================================= */
(function () {
  "use strict";
  // Khi nhúng bằng fc-widget.js, giao diện nằm trong Shadow DOM (window.__fcRoot) để không đụng CSS của trang chủ
  const ROOT = window.__fcRoot || document;
  const $ = (s, el = ROOT) => el.querySelector(s);
  const $$ = (s, el = ROOT) => [...el.querySelectorAll(s)];
  const fixHref = (h) => (window.__fc && window.__fc.fix ? window.__fc.fix(h) : h);
  const isExternal = (h) => { try { return new URL(h, location.href).origin !== location.origin; } catch (e) { return false; } };
  const box = $("#chatbox");
  if (!box) return;
  const fc = () => window.__fc || { CONFIG: {}, project: "", hasDrive: false, drive: "", track() {}, sendLead: async () => {}, openForm() {} };
  const ss = {
    get(k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
    set(k, v) { try { sessionStorage.setItem(k, v); } catch (e) { /* bỏ qua */ } },
  };
  const log = $("[data-chat-log]", box), chips = $("[data-chat-chips]", box), form = $("[data-chat-form]", box), input = form.q;
  const sid = ss.get("fc_chat_sid") || (() => { const v = Math.random().toString(36).slice(2) + Date.now().toString(36); ss.set("fc_chat_sid", v); return v; })();
  const st = { kb: null, history: [], awaitPhone: false, leadSent: !!ss.get("fc_chat_lead"), aiOff: false, asked: [], ctx: "" };

  /* ---------- Chuẩn hoá tiếng Việt để so khớp ---------- */
  const norm = (s) => String(s || "").toLowerCase().normalize("NFD").replace(/[̀-ͯ]/g, "").replace(/đ/g, "d").replace(/\s+/g, " ").trim();
  // từ ngắn (≤3 ký tự: "gia", "ty", "coc"…) phải khớp nguyên từ để "gia đình" không bị hiểu là hỏi giá
  const has = (t, words) => words.some((w) => (w.length <= 3 ? new RegExp("(^|[^a-z0-9])" + w + "([^a-z0-9]|$)").test(t) : t.includes(w)));
  const nf = (n) => String(n).replace(".", ",");
  const pad = (n) => String(n).padStart(2, "0");

  async function loadKb() {
    if (st.kb) return st.kb;
    if (fc().kb) return (st.kb = fc().kb);
    try { st.kb = await (await fetch("/assets/chat-kb.json", { cache: "force-cache" })).json(); }
    catch (e) { st.kb = { projects: [], zones: [], city: {}, fp4: { floors: [], units: [], types: {} } }; }
    return st.kb;
  }

  /* ---------- Hiển thị tin nhắn (an toàn: chỉ text node, link nội bộ / tel / zalo) ---------- */
  function richText(el, text) {
    const re = /\*\*(.+?)\*\*|\[([^\]]+)\]\(((?:\/|tel:|https:\/\/zalo\.me\/)[^)\s]*)\)/g;
    String(text).split("\n").forEach((line, i) => {
      if (i) el.appendChild(document.createElement("br"));
      let last = 0, m;
      while ((m = re.exec(line))) {
        if (m.index > last) el.appendChild(document.createTextNode(line.slice(last, m.index)));
        if (m[1]) { const b = document.createElement("b"); b.textContent = m[1]; el.appendChild(b); }
        else { const a = document.createElement("a"); a.textContent = m[2]; a.href = fixHref(m[3]); if (isExternal(a.href)) { a.target = "_blank"; a.rel = "noopener"; } el.appendChild(a); }
        last = re.lastIndex;
      }
      if (last < line.length) el.appendChild(document.createTextNode(line.slice(last)));
    });
  }
  function say(who, text, actions) {
    const row = document.createElement("div");
    row.className = "msg " + who;
    const bubble = document.createElement("div");
    bubble.className = "bubble";
    richText(bubble, text);
    row.appendChild(bubble);
    if (actions && actions.length) {
      const wrap = document.createElement("div");
      wrap.className = "msg-actions";
      actions.forEach((a) => {
        const el = document.createElement(a.href ? "a" : "button");
        el.textContent = a.label;
        el.className = a.primary ? "act primary" : "act";
        if (a.href) { el.href = fixHref(a.href); if (isExternal(el.href)) { el.target = "_blank"; el.rel = "noopener"; } }
        else { el.type = "button"; el.onclick = a.onClick; }
        wrap.appendChild(el);
      });
      row.appendChild(wrap);
    }
    log.appendChild(row);
    log.scrollTop = log.scrollHeight;
    st.history.push({ role: who === "me" ? "user" : "assistant", content: String(text).slice(0, 1200) });
    if (st.history.length > 16) st.history = st.history.slice(-16);
  }
  function typing(on) {
    let t = $(".msg.typing", log);
    if (on && !t) { t = document.createElement("div"); t.className = "msg bot typing"; t.innerHTML = '<div class="bubble"><i></i><i></i><i></i></div>'; log.appendChild(t); log.scrollTop = log.scrollHeight; }
    if (!on && t) t.remove();
  }
  function setChips(list) {
    chips.innerHTML = "";
    list.forEach((c) => {
      const b = document.createElement("button");
      b.type = "button"; b.textContent = c;
      b.onclick = () => handle(c);
      chips.appendChild(b);
    });
  }

  /* ---------- Hiểu câu hỏi ---------- */
  const T = {
    hello: ["chao", "hello", "hi ", "alo", "xin chao"],
    price: ["gia", "bao nhieu tien", "ty", "trieu", "chiet khau", "uu dai", "chinh sach ban"],
    plan: ["mat bang", "dien tich", "loai can", "1pn", "2pn", "3pn", "phong ngu", "duplex", "m2", "layout", "can nao", "can goc"],
    progress: ["tien do", "ban giao", "khi nao", "bao gio", "hoan thanh", "mo ban", "xay den dau", "khoi cong", "nhan nha"],
    location: ["vi tri", "o dau", "dia chi", "cach", "bien", "san bay", "trung tam", "duong nao", "ban do"],
    legal: ["phap ly", "so hong", "so do", "hop dong", "so huu", "lau dai"],
    pay: ["thanh toan", "vay", "ngan hang", "lai suat", "tra gop", "dat coc", "coc"],
    amen: ["tien ich", "ho boi", "gym", "truong", "cong vien", "sieu thi", "vuon"],
    human: ["tu van", "chuyen vien", "nhan vien", "sale", "goi lai", "goi cho", "gap", "lien he", "hotline", "zalo"],
    doc: ["tai lieu", "brochure", "drive", "file", "gui cho", "pdf"],
    count: ["bao nhieu can", "so can", "may can", "bao nhieu tang", "may tang", "quy mo"],
  };

  function detectProject(t, kb) {
    const m = t.match(/(?:fpt\s*)?(?:plaza|pl|p)\s*([1-5])\b/) || t.match(/\bfpt\s*([1-5])\b/);
    if (m) return kb.projects.find((p) => p.name.endsWith(" " + m[1]));
    const z = t.match(/\bv\s*([1-9])\b/);
    if (z && (t.includes("dat") || t.includes("phan khu") || t.length < 12)) return { zone: kb.zones.find((x) => x.code === "V" + z[1]) };
    if (t.includes("dat nen") || t.includes("phan khu") || /\bdat\b/.test(t)) return { land: true };
    return null;
  }
  function pageContext(kb) {
    const p = fc().project || "";
    const zp = p.match(/V(\d)/);
    if (zp) return { zone: kb.zones.find((x) => x.code === "V" + zp[1]) };
    if (/đất nền/i.test(p)) return { land: true };
    return kb.projects.find((x) => x.name === p) || null;
  }
  const spec = (p, key) => (p.specs.find((s) => norm(s[0]).includes(norm(key))) || [])[1];

  function unitLookup(text, kb) {
    const m = text.match(/\b([ns])\s*-?\s*(\d{1,2})\s*[.\-\s]\s*(\d{1,2}a?)\b/i);
    if (!m) return null;
    const block = m[1].toUpperCase(), floor = +m[2];
    let no = m[3].toUpperCase(); if (/^\d$/.test(no)) no = "0" + no; if (/^\dA$/.test(no)) no = "0" + no;
    const code = `${block}-${pad(floor)}.${no}`;
    const f = kb.fp4.floors.find((x) => floor >= x.from && floor <= x.to);
    if (!f) return { code, text: `FPT Plaza 4 có căn hộ từ tầng 3 đến tầng 20, mình chưa thấy tầng ${floor}. Bạn kiểm tra lại mã căn giúp mình nhé (dạng N-12.12).` };
    const u = kb.fp4.units.find((x) => x[0] === f.id && x[1] === block && x[2] === no);
    if (!u) return { code, text: `Mình chưa tìm thấy căn **${code}** trên mặt bằng FPT Plaza 4 (lưu ý: không có căn số 13, có căn 12A). Bạn gửi lại mã giúp mình nhé.` };
    const type = kb.fp4.types[u[3]] || u[3];
    let extra = "";
    if (u[3].startsWith("DUP")) {
      const other = kb.fp4.units.find((x) => x[0] === (f.id === "19" ? "20" : "19") && x[1] === block && x[2] === no);
      if (other) extra = `\nĐây là căn **Duplex thông tầng 19–20**, tổng khoảng **${nf((u[4] + other[4]).toFixed(2))} m²** (tầng ${f.id}: ${nf(u[4])} m²).`;
    }
    const lay = (kb.fp4.layouts || []).find((l) => l.units.some(([b, n, from, to]) => b === block && n === no && floor >= from && floor <= to));
    if (lay) extra += `\n📐 [Xem layout căn ${code}](${lay.img})`;
    return { code, unit: `${code} · ${type} · ${nf(u[4])} m²`,
      text: `Căn **${code}** – FPT Plaza 4: **${type}**, diện tích **${nf(u[4])} m²**, khối ${block === "N" ? "N (Bắc)" : "S (Nam)"}, tầng ${floor}.${extra}\nGiá căn này phụ thuộc tầng, hướng và chính sách hiện hành – để lại SĐT/Zalo, chuyên viên gửi giá chính xác cho bạn ngay.` };
  }

  function faqSearch(t, list) {
    const words = t.split(/[^a-z0-9]+/).filter((w) => w.length > 2);
    let best = null, score = 0;
    list.forEach(([q, a]) => {
      const nq = norm(q);
      const sc = words.reduce((s, w) => s + (nq.includes(w) ? (w.length > 4 ? 2 : 1) : 0), 0);
      if (sc > score) { score = sc; best = a; }
    });
    return score >= 4 ? best : null;
  }

  function ruleAnswer(text, kb) {
    const t = " " + norm(text).replace(/\bgia (dinh|han|dung|nhap)\b/g, " ") + " "; // bỏ dấu thì "gia đình" giống "giá": loại các cụm này trước khi nhận diện ý
    const found = detectProject(t, kb);
    const target = found || st.ctx || pageContext(kb);
    if (found) st.ctx = found;
    const p = target && target.name ? target : null;
    const allFaq = kb.projects.flatMap((x) => x.faq);
    const ask = (msg) => { st.awaitPhone = !st.leadSent; return msg + (st.leadSent ? "" : "\n👉 Bạn để lại **SĐT/Zalo** (kèm tên) ngay trong khung chat, chuyên viên gửi ngay cho bạn nhé."); };
    const priceAct = [{ label: "📥 Nhận bảng giá", primary: true, onClick: () => fc().openForm(p ? p.name + " · Bảng giá" : "") }];

    if (has(t, T.hello) && t.length < 20) return { sure: true, text: "Chào bạn 👋 Mình là trợ lý tự động của FPT City. Bạn quan tâm **căn hộ FPT Plaza** hay **đất nền FPT City**? Bạn cũng có thể gõ mã căn (VD: N-12.12) để xem diện tích." };

    if (has(t, T.price)) {
      if (target && target.zone) return { sure: true, text: ask(`Giá đất **phân khu ${target.zone.code}** thay đổi theo từng lô (vị trí, hướng, mặt tiền đường). Mình gửi bạn **giỏ hàng & giá từng lô** mới nhất.`), actions: priceAct };
      if (target && target.land) return { sure: true, text: ask("Giá đất nền FPT City khác nhau theo phân khu V1–V6 và từng lô. Mình gửi bạn **bản đồ phân lô + giỏ hàng** mới nhất."), actions: priceAct };
      if (p) return { sure: true, text: ask(`Giá **${p.name}** thay đổi theo tầng, hướng, loại căn và đợt chính sách (${p.status}). Mình gửi bạn **bảng giá + chính sách thanh toán** mới nhất kèm mặt bằng.`), actions: priceAct };
      return { sure: true, text: ask("Giá phụ thuộc dự án và từng căn. Bạn quan tâm FPT Plaza nào (1, 2, 3, 4, 5) hay đất nền? Mình gửi bảng giá mới nhất."), actions: priceAct };
    }
    if (has(t, T.count) && p) {
      const lines = [spec(p, "quy mô"), spec(p, "số căn"), spec(p, "tầng điển hình")].filter(Boolean);
      if (lines.length) return { sure: true, text: `**${p.name}**: ${lines.join(" · ")}.` };
    }
    if (has(t, T.plan)) {
      if (p) {
        const units = p.units.map(([k, v]) => `• ${k}: ${v}`).join("\n");
        const tip = p.name === "FPT Plaza 4" ? "\nBạn gõ **mã căn** (VD: N-12.12) để xem chính xác, hoặc xem [mặt bằng từng tầng](/fpt-plaza-4/#mat-bang-tang)." : "";
        return { sure: true, text: `Loại căn & diện tích **${p.name}** (tham khảo):\n${units}${tip}`, actions: [{ label: "📐 Nhận mặt bằng chi tiết", primary: true, onClick: () => fc().openForm(p.name + " · Mặt bằng") }] };
      }
      if (target && (target.zone || target.land)) return { sure: true, text: ask("Đất nền FPT City có lô phổ biến ~90–105 m², lô góc và biệt thự 200–350+ m² (tuỳ phân khu). Mình gửi bản đồ phân lô chi tiết.") };
    }
    if (has(t, T.progress) && p) {
      const lines = [spec(p, "khởi công"), spec(p, "thi công"), spec(p, "mở bán"), spec(p, "bàn giao"), spec(p, "tình trạng")].filter(Boolean);
      const f = faqSearch(t, p.faq);
      return { sure: true, text: f || `**${p.name}** – ${p.status}.\n${lines.map((x) => "• " + x).join("\n")}` };
    }
    if (has(t, T.location)) {
      const extra = p && spec(p, "mặt tiền") ? `\n**${p.name}**: ${spec(p, "mặt tiền")}.` : "";
      return { sure: true, text: `📍 ${kb.city.name} – ${kb.city.location}${extra}`, actions: [{ label: "Xem bản đồ", href: (p ? p.url : "/") + "#vi-tri" }] };
    }
    if (has(t, T.amen)) return { sure: true, text: `Tiện ích ${kb.city.name}: ${kb.city.amenities}${p && spec(p, "tiện ích") ? `\n**${p.name}**: ${spec(p, "tiện ích")}.` : ""}` };
    if (has(t, T.legal)) {
      if (target && (target.zone || target.land)) return { sure: true, text: ask("Đất nền FPT City được cấp **sổ đỏ từng lô**; mỗi lô được kiểm tra pháp lý cụ thể trước khi giao dịch.") };
      const f = p && faqSearch(t, p.faq);
      return { sure: true, text: ask(f || "Căn hộ FPT Plaza sở hữu lâu dài với người Việt Nam. Dự án đang bán theo hình thức nhà ở hình thành trong tương lai khi đã được Sở Xây dựng xác nhận đủ điều kiện. Chuyên viên sẽ gửi bạn hồ sơ pháp lý chi tiết.") };
    }
    if (has(t, T.pay)) return { sure: true, text: ask(`${p ? "**" + p.name + "**: " : ""}thanh toán theo tiến độ, có ngân hàng hỗ trợ vay. Chính sách cụ thể (tỷ lệ vay, ân hạn lãi, chiết khấu) thay đổi theo đợt – mình gửi bạn bảng tính dòng tiền chi tiết.`) };
    if (has(t, T.doc)) return { sure: true, text: ask("Bộ tài liệu gồm brochure, mặt bằng, bảng giá và chính sách."), actions: priceAct };
    if (has(t, T.human)) return { sure: true, text: ask(`Bạn có thể gọi ngay hoặc nhắn Zalo cho chuyên viên. Hoặc để lại số, chuyên viên gọi lại trong ít phút.`), actions: [{ label: "📞 Gọi ngay", href: $("[data-hotline-link]")?.href || "tel:" }, { label: "Zalo", href: $("[data-zalo-link]")?.href || "#" }] };
    if (target && target.zone) return { sure: false, text: `**Đất nền FPT City phân khu ${target.zone.code}**: ${target.zone.lead}\n${target.zone.traits.map((x) => "• " + x).join("\n")}`, actions: [{ label: "Xem phân khu " + target.zone.code, href: target.zone.url }] };
    const f = faqSearch(t, p ? p.faq.concat(allFaq) : allFaq);
    if (f) return { sure: false, text: f };
    if (found && p) return { sure: false, text: `**${p.name}** (${p.status}): ${p.lead}`, actions: [{ label: "Xem " + p.name, href: p.url }, { label: "📥 Nhận bảng giá", primary: true, onClick: () => fc().openForm(p.name) }] };
    return null;
  }

  /* ---------- SĐT trong tin nhắn → gửi lead ---------- */
  function extractPhone(text) {
    const m = text.match(/(?:\+?84|0)(?:[\s.\-]?\d){8,10}/);
    if (!m) return null;
    let p = m[0].replace(/[^\d+]/g, "");
    if (p.startsWith("+84")) p = "0" + p.slice(3); else if (p.startsWith("84")) p = "0" + p.slice(2);
    if (!/^0(3|5|7|8|9)\d{8}$/.test(p)) return { invalid: true };
    const STOP = new Set(["sdt", "so", "dt", "zalo", "cua", "toi", "em", "anh", "chi", "minh", "ten", "la", "day", "nhe", "nha", "a", "oi", "goi", "lai", "cho", "nhan", "dien", "thoai", "lien", "he", "qua", "va", "ah", "ạ"]);
    const name = text.replace(m[0], " ").replace(/[^\p{L}\s]/gu, " ").split(/\s+/).filter((w) => w && !STOP.has(norm(w))).join(" ").trim();
    return { phone: p, name: name.length >= 2 && name.length <= 40 ? name : "" };
  }
  async function submitLead(info) {
    const kb = await loadKb();
    const ctx = st.ctx || pageContext(kb);
    const proj = ctx && ctx.name ? ctx.name : ctx && ctx.zone ? "Đất nền FPT City " + ctx.zone.code : ctx && ctx.land ? "Đất nền FPT City" : fc().project || "Website";
    const need = ("Chat: " + st.asked.slice(-3).join(" | ")).slice(0, 200);
    try { await fc().sendLead({ name: info.name || "Khách chat", phone: info.phone, need, project: proj, source: "chat" }); } catch (e) { /* vẫn cảm ơn khách */ }
    st.leadSent = true; st.awaitPhone = false; ss.set("fc_chat_lead", "1");
    const acts = fc().hasDrive ? [{ label: "📂 Mở tài liệu Google Drive", primary: true, href: fc().drive }] : [];
    say("bot", `Cảm ơn ${info.name || "bạn"} 🙏 Mình đã chuyển số **${info.phone}** cho chuyên viên – bạn sẽ được gọi/nhắn Zalo trong ít phút.${fc().hasDrive ? "\nTrong lúc chờ, bạn xem tài liệu dự án tại đây:" : ""}`, acts);
  }

  /* ---------- AI qua CRM (tuỳ chọn) ---------- */
  async function aiAnswer() {
    const C = fc().CONFIG || {};
    if (!C.chatAI || !C.leadEndpoint || st.aiOff) return null;
    try {
      const ctrl = new AbortController();
      const timer = setTimeout(() => ctrl.abort(), 25000);
      const r = await fetch(C.leadEndpoint, {
        method: "POST", signal: ctrl.signal,
        body: new URLSearchParams({ action: "chat", sid, page: location.pathname, project: fc().project || "", history: JSON.stringify(st.history.slice(-12)) }),
      });
      clearTimeout(timer);
      const d = await r.json();
      if (d && d.ok && d.reply) return { text: d.reply };
      if (d && (d.error === "disabled" || d.error === "limit")) st.aiOff = true;
    } catch (e) { /* rơi về trả lời tự động */ }
    return null;
  }

  async function handle(raw) {
    const text = String(raw || "").trim().slice(0, 400);
    if (!text) return;
    say("me", text);
    input.value = "";
    const kb = await loadKb();

    const ph = extractPhone(text);
    if (!ph) st.asked.push(text.slice(0, 80));
    if (ph && ph.invalid) { say("bot", "Số điện thoại có vẻ chưa đúng 🤔 Bạn kiểm tra lại giúp mình (VD: 0905 123 456) nhé."); return; }
    if (ph) { await submitLead(ph); setChips(["Mặt bằng FPT Plaza 4", "Tiến độ bàn giao", "Đất nền FPT City"]); return; }

    const unit = unitLookup(text, kb);
    if (unit) {
      st.ctx = kb.projects.find((p) => p.name === "FPT Plaza 4") || st.ctx;
      st.awaitPhone = !st.leadSent;
      say("bot", unit.text, unit.unit ? [{ label: "💰 Nhận giá căn " + unit.code, primary: true, onClick: () => fc().openForm("FPT Plaza 4 · " + unit.unit) }] : []);
      fc().track("chat_unit", { unit: unit.code });
      return;
    }

    typing(true);
    let ans = ruleAnswer(text, kb);
    if (!ans || !ans.sure) {
      const ai = await aiAnswer();
      if (ai) ans = { text: ai.text, actions: ans && ans.actions };
    }
    await new Promise((r) => setTimeout(r, 350));
    typing(false);
    if (!ans) {
      ans = { text: `Câu này mình cần chuyên viên hỗ trợ thêm 🙏 ${st.leadSent ? "Chuyên viên sẽ liên hệ bạn sớm." : "Bạn để lại **SĐT/Zalo** ngay tại đây, hoặc gọi trực tiếp nhé."}`,
        actions: [{ label: "📞 Gọi ngay", href: $("[data-hotline-link]")?.href || "tel:" }] };
      st.awaitPhone = !st.leadSent;
    }
    say("bot", ans.text, ans.actions);
    fc().track("chat_message", { project: fc().project });
  }

  /* ---------- Mở / đóng ---------- */
  const openBtns = $$("[data-chat-open]");
  const teaser = $("[data-chat-teaser]");
  async function open() {
    box.hidden = false;
    openBtns.forEach((b) => b.setAttribute && b.setAttribute("aria-expanded", "true"));
    if (teaser) teaser.hidden = true;
    const badge = $("[data-chat-badge]"); if (badge) badge.hidden = true;
    ss.set("fc_chat_seen", "1");
    if (!log.children.length) {
      const kb = await loadKb();
      const ctx = pageContext(kb);
      const where = ctx && ctx.name ? `**${ctx.name}**` : ctx && ctx.zone ? `**đất nền phân khu ${ctx.zone.code}**` : "**FPT City Đà Nẵng**";
      say("bot", `Xin chào 👋 Mình là trợ lý tự động, hỗ trợ thông tin ${where} 24/7.\nBạn muốn xem gì? Chọn nhanh bên dưới hoặc gõ câu hỏi / mã căn (VD: **N-12.12**).`);
      const p4 = ctx && ctx.name === "FPT Plaza 4";
      setChips(p4 ? ["Bảng giá FPT Plaza 4", "Loại căn & diện tích", "Căn Duplex", "Khi nào bàn giao?", "Vị trí dự án", "Gặp chuyên viên"]
        : ctx && (ctx.zone || ctx.land) ? ["Giá đất nền", "Pháp lý sổ đỏ", "Vị trí", "Gặp chuyên viên"]
          : ["Bảng giá FPT Plaza 4", "FPT Plaza 5 khi nào mở bán?", "Đất nền FPT City", "Vị trí FPT City", "Gặp chuyên viên"]);
    }
    setTimeout(() => input.focus(), 50);
    fc().track("chat_open", { project: fc().project });
  }
  function close() {
    box.hidden = true;
    openBtns.forEach((b) => b.setAttribute && b.setAttribute("aria-expanded", "false"));
  }
  openBtns.forEach((b) => b.addEventListener("click", () => (box.hidden ? open() : close())));
  $("[data-chat-close]", box).addEventListener("click", close);
  document.addEventListener("keydown", (e) => { if (e.key === "Escape" && !box.hidden) close(); });
  form.addEventListener("submit", (e) => { e.preventDefault(); handle(input.value); });
  if (teaser) $("[data-teaser-close]", teaser).addEventListener("click", (e) => { e.stopPropagation(); teaser.hidden = true; ss.set("fc_chat_seen", "1"); });

  const delay = (fc().CONFIG && fc().CONFIG.chatTeaserSeconds) || 0;
  if (delay > 0 && teaser && !ss.get("fc_chat_seen")) {
    setTimeout(() => { if (box.hidden && !document.querySelector("dialog[open]")) teaser.hidden = false; }, delay * 1000);
  }
  // cho phép mở chat từ nơi khác: <a href="#chat">
  if (location.hash === "#chat") open();

  // dùng cho kiểm thử
  window.__fcChat = { handle, unitLookup: (t) => loadKb().then((kb) => unitLookup(t, kb)), extractPhone };
})();

  }
  if (document.body) mount(); else document.addEventListener("DOMContentLoaded", mount);
})();
