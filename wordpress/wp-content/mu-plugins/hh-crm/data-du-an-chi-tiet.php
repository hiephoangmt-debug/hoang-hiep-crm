<?php
/**
 * Bổ sung dữ liệu công khai cho các dự án (thu thập 10/2026 từ nguồn công khai).
 * Hàm hh_import_projects() gộp phần này vào dữ liệu dự án (chỉ điền ô còn trống).
 * Chỉ ghi các thông tin có nguồn nêu rõ; khoảng cách / thời gian di chuyển là số liệu ước lượng do nguồn công bố.
 */
defined( 'ABSPATH' ) || exit;

function hh_project_enrichment() {
	return array(

		'hoiana-resort-golf' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Quần thể Hoiana Resort & Golf nằm trên dải bờ biển nguyên sơ phía Nam Hội An, thuộc xã Duy Hải, Duy Xuyên (Quảng Nam cũ), nay thuộc TP. Đà Nẵng. Quần thể cách phố cổ Hội An khoảng 15 phút lái xe và cách sân bay quốc tế Đà Nẵng khoảng 45 phút.",
				'hh_p_connections'   => "15 phút | Phố cổ Hội An\nKhoảng 45 phút (33,4 km) | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in'  => "Sân golf Hoiana Shores do Robert Trent Jones Jr. thiết kế\nKhu phức hợp giải trí có casino (140 bàn chơi, 10 phòng VIP, 360 máy slot)\nBeach club NOX\nKids club 2.700 m²\nKhoảng 1.200 phòng thuộc 4 khách sạn (New World Hoiana Beach Resort, New World Hoiana Hotel, Hoiana Hotel & Suites, Hoiana Residences)\nSpa\nHồ bơi vô cực hướng biển\nNhà hàng, trung tâm mua sắm",
			),
			'sources' => array(
				'https://www.agoda.com/special-editions/hoiana/hoiana-resort-and-golf-best-integrated-resort-in-asia/',
				'https://tapchivietduc.vn/hoiana-resort-and-golf-khu-nghi-duong-phuc-hop-hang-dau-the-gioi-nam-2024-a26237.html',
				'https://vntravellive.com/hoiana-resort-golf--to-hop-nghi-duong-va-giai-tri-dang-cap-d34764.html',
			),
		),

		'sun-symphony-residence' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Sun Symphony Residence nằm trên trục Trần Hưng Đạo – Lê Văn Duyệt, phường Nại Hiên Đông (cũ), Sơn Trà, ngay bờ Đông sông Hàn, nhìn sang trung tâm thành phố. Dự án ở vị trí ven sông, gần cửa sông Hàn, kết nối nhanh tới các quận trung tâm của Đà Nẵng.",
				'hh_p_connections'   => "3 phút | Cầu quay sông Hàn\n5 phút | Cầu Rồng, cầu Tình Yêu\n5 phút | Trung tâm Hành chính Đà Nẵng\n5 phút | Biển Mỹ Khê, biển Phạm Văn Đồng\n15 phút | Sân bay quốc tế Đà Nẵng\n15 phút | Asia Park, công viên APEC",
				'hh_p_amenities_in'  => "Công viên trung tâm Central Park 5.000 m²\n3 bến du thuyền nội khu\nĐường dạo bộ ven sông Hàn\nHồ bơi vô cực\nHồ bơi trong nhà\nSky lounge, bistro nhà kính trên tầng cao\nPhòng gym\nKids club\nSpa cao cấp\nKhu BBQ\nQuảng trường, đài ngắm cảnh, tiểu cảnh điêu khắc\nSân tập thể thao",
				'hh_p_progress'      => "30/6/2025 | Cất nóc cả 3 tòa căn hộ S1, S2, S3\nTháng 6/2026 | Bàn giao căn hộ (kế hoạch, trùng Lễ hội pháo hoa quốc tế Đà Nẵng)",
			),
			'sources' => array(
				'https://vnexpress.net/tiem-nang-thuong-mai-tai-thuong-cang-sun-symphony-residence-da-nang-4776875.html',
				'https://skyrealty.vn/sun-property-gioi-thieu-sieu-pham-sun-symphony-residence-ben-dong-song-anh-sang/',
				'https://cafeland.vn/du-an/du-an-sun-symphony-residence-da-nang-4336.html',
				'https://sungroupsr.vn/tien-do-sun-symphony-residence/',
				'https://scdgroup.vn/tin-tuc/sun-symphony-residence-thang-42026-dien-mao-hoan-thien-san-sang-ban-giao-giua-mua-le-hoi',
			),
		),

		'sun-cosmo-residence' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Sun Cosmo Residence nằm tại giao lộ Trần Hưng Đạo – Chương Dương – Nguyễn Văn Thoại, sát chân cầu Trần Thị Lý, bờ Đông sông Hàn. Dự án kết nối các trục Chương Dương, Mỹ An, Phạm Hữu Kính và giao lộ Nguyễn Văn Trỗi – Quốc lộ 17.",
				'hh_p_connections'   => "Khoảng 2 km | Biển Mỹ Khê\nSát chân cầu | Cầu Trần Thị Lý",
				'hh_p_amenities_in'  => "Bể bơi\nPhòng gym\nSpa\nKhu thể dục thể thao trong nhà\nSky garden\nKhu thương mại bán lẻ (retail)\nCông viên cảnh quan",
				'hh_p_progress'      => "Quý 1/2023 | Khởi công\nTháng 10/2024 | Cất nóc khối căn hộ\nCuối 2025 – đầu 2026 | Bàn giao (dự kiến)",
			),
			'sources' => array(
				'https://rever.vn/du-an/sun-cosmo-residence',
				'https://cafeland.vn/du-an/sun-cosmo-residence-du-an-can-ho-biet-thu-nha-pho-tai-da-nang-3989.html',
				'https://reti.vn/blog/tien-ich-du-an-sun-cosmo-residence-tong-the-tien-ich-toan-du-an/',
				'https://suncosmo.vn/can-canh-tien-do-trien-khai-du-an-sun-cosmo-residence-thang-10-2024/',
			),
		),

		'sun-ponte-residence' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Sun Ponte Residence tọa lạc mặt tiền đường Trần Hưng Đạo, trung tâm Sơn Trà, ngay bên bờ sông Hàn. Dự án nằm giữa cầu Rồng và cầu Trần Thị Lý, trên khu đất khoảng 1,6 ha.",
				'hh_p_connections'   => "1 phút | Cầu Rồng\n2 phút | Cầu sông Hàn\n3 – 5 phút | Biển Mỹ Khê\n10 phút | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in'  => "Hồ bơi vô cực view toàn cảnh thành phố\nBể Jacuzzi\nPhòng gym, yoga\nSpa, xông hơi\nKids club, khu vui chơi trẻ em\nKhu thể thao ngoài trời\nKhu BBQ ngoài trời\nCông viên ven sông, đường chạy bộ\nNhà hàng, café\nKhông gian sinh hoạt cộng đồng\nAn ninh 24/7",
				'hh_p_progress'      => "Quý 1/2024 | Khởi công\nQuý 4/2025 | Cất nóc (kế hoạch)\nTháng 3/2026 | Bắt đầu bàn giao căn hộ phân khu The Ponte\nQuý 3/2026 | Hoàn tất bàn giao (dự kiến)",
			),
			'sources' => array(
				'https://e.vnexpress.net/photo/vietnamproperty/sun-ponte-residence-after-two-years-of-construction-5086492.html',
				'https://vnexpress.net/to-hop-sun-ponte-residence-mat-song-han-sau-2-nam-thi-cong-5078528.html',
				'https://thuviennhadat.vn/bat-dong-san/tien-do-sun-ponte-residence-da-nang-cap-nhat-moi-nhat-2025-20593.html',
				'https://cvr.com.vn/vi/tong-quan-du-an-sun-ponte-residence-da-nang',
				'https://newdathanh.vn/can-ho-cao-cap-hh3-da-nang-bieu-tuong-thuong-luu-tren-dong-song-han-.html',
			),
		),

		'peninsula-da-nang' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Peninsula Đà Nẵng nằm tại khu A2-1, đường Lê Văn Duyệt, phường Nại Hiên Đông (cũ), Sơn Trà, ở khúc cua Lê Văn Duyệt – Trần Hưng Đạo, gần cầu Thuận Phước. Khu đất 7.167,5 m² có 4 mặt tiền và 3 mặt hướng sông Hàn.",
				'hh_p_connections'   => "2 phút | Cầu sông Hàn, TTTM Vincom\n5 phút (khoảng 1,2 km) | Cầu Rồng\n5 – 7 phút | Biển Mỹ Khê\n10 – 12 phút | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in'  => "Hồ bơi vô cực tầng 30\nPhòng gym\nPhòng yoga\nSpa\nThư viện\nKid zone, khu sinh hoạt chung\nSân vườn\nCafé\nSiêu thị, khu thương mại\nTầng hầm đỗ xe",
				'hh_p_progress'      => "Quý 2/2024 | Khởi công\nTháng 5/2025 | Hoàn thành kết cấu sàn tầng 6, thi công tầng 7\nQuý 4/2026 | Hoàn thành (dự kiến)",
			),
			'sources' => array(
				'https://cafeland.vn/du-an/du-an-can-ho-peninsula-da-nang-4522.html',
				'https://peninsula.vn/',
				'https://cdcxd.com.vn/du-an/the-muse-da-nang/',
			),
		),

		'hiyori-garden-tower' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Hiyori Garden Tower tọa lạc tại Lô 2 – A2 đường Võ Văn Kiệt, phường An Hải Đông (cũ), Sơn Trà. Tòa nhà có 4 mặt tiền: Võ Văn Kiệt, Phạm Cự Lượng, Phạm Quang Ảnh và An Trung Đông 3, cách biển Mỹ Khê khoảng 1 km.",
				'hh_p_connections'   => "Khoảng 1 km (2 phút) | Biển Mỹ Khê",
				'hh_p_amenities_in'  => "Hồ bơi\nPhòng tập gym\nNhà trẻ tiêu chuẩn Nhật Bản\nCông viên\nKhu sinh hoạt cộng đồng\nCửa hàng tiện ích\nVăn phòng làm việc\nSảnh lễ tân",
				'hh_p_progress'      => "Tháng 5/2017 | Khởi công\nTháng 12/2019 | Bàn giao",
			),
			'sources' => array(
				'https://pmcweb.vn/project/hiyori-garden-tower/',
				'https://homedy.com/news/review-chi-tiet-chung-cu-hiyori-da-nang-ne6550',
				'https://toprealty.vn/du-an/hiyori-garden-tower-da-nang/',
			),
		),

		'the-ori-garden' => array(
			'meta'    => array(
				'hh_p_location_desc' => "The Ori Garden nằm tại lô B4-1 và B4-2 Khu đô thị xanh Bàu Tràm Lakeside, phường Hòa Hiệp Nam (cũ), Liên Chiểu, ở vị trí trung tâm cụm đô thị phía Bắc thành phố. Dự án rộng 4,03 ha gồm 10 tòa 21 tầng, cách biển khoảng 2,3 km.",
				'hh_p_connections'   => "Khoảng 2,3 km | Biển Đà Nẵng (Liên Chiểu)",
				'hh_p_amenities_in'  => "Quảng trường (plaza)\nHồ bơi người lớn và trẻ em\nSân thể thao đa năng\nVườn BBQ\nThư viện\nNhà trẻ\nCông viên\nShophouse dịch vụ khối đế\nAn ninh 24/7",
				'hh_p_amenities_out' => "Tiện ích Khu đô thị xanh Bàu Tràm Lakeside\nTrường học, bệnh viện, trung tâm mua sắm khu vực Liên Chiểu",
				'hh_p_progress'      => "Tháng 4/2021 | Khởi công giai đoạn 1\nTháng 5/2023 | Bàn giao giai đoạn 1\nĐầu 2024 | Cư dân tòa CT3 nhận sổ hồng\nQuý 4/2024 | Bàn giao giai đoạn 2 (kế hoạch)",
			),
			'sources' => array(
				'https://dantri.com.vn/bat-dong-san/the-ori-garden-ghi-diem-voi-khach-hang-nho-thuc-hien-dung-cac-cam-ket-20240301135707602.htm',
				'https://thuvienphapluat.vn/nha-dat/tong-quan-du-an-the-ori-garden-gia-can-ho-du-an-the-ori-garden-da-nang-ra-sao-1245.html',
				'https://batdongsan.com.vn/du-an-nha-o-xa-hoi-lien-chieu-ddn/the-ori-garden-pj5370',
			),
		),

		'the-legend-da-nang' => array(
			'meta'    => array(
				'hh_p_location_desc' => "The Legend Đà Nẵng tọa lạc trên đường Võ Văn Kiệt, phường An Hải Tây (cũ), Sơn Trà, ngay đầu cầu Rồng và kề sông Hàn. Khu đất 11.200 m² gồm 2 tòa tháp 29 và 25 tầng nổi, 3 tầng hầm.",
				'hh_p_connections'   => "Đầu cầu | Cầu Rồng\nKhoảng 3,5 km | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in'  => "Hồ bơi vô cực 1.000 m²\nSky bar 360°\nPhòng gym\nSpa\nTrung tâm thương mại khối đế\nNhà hàng, quầy bar view sông\nKhu vui chơi trẻ em\nKhông gian sinh hoạt cộng đồng\nCông viên xanh trên 1.350 m²\nBãi đỗ xe, an ninh 24/7",
				'hh_p_progress'      => "28/2/2025 | Khởi công\nTháng 10/2025 | Hoàn thành khoảng 70% dầm, sàn, cột, vách hầm B2; thi công đào hầm B3\nQuý 4/2027 | Hoàn thành (dự kiến)\nQuý 1/2028 | Bàn giao (dự kiến)",
			),
			'sources' => array(
				'https://dantri.com.vn/bat-dong-san/tien-do-du-an-the-legend-danang-20251114105051807.htm',
				'https://baodautu.vn/batdongsan/chu-dau-tu-the-legend-danang-day-nhanh-tien-do-thi-cong-du-an-d433621.html',
				'https://baohatinh.vn/the-legend-city-da-nang-cap-nhat-tien-do-va-chinh-sach-ban-hang-moi-nhat-post313165.html',
			),
		),

		'times-square-da-nang' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Times Square Đà Nẵng nằm mặt tiền đường Võ Nguyên Giáp, trực diện biển Mỹ Khê, Sơn Trà. Khu đất có 4 mặt tiền trên các trục Võ Nguyên Giáp và Phạm Văn Đồng, khoảng 80% căn hộ có view biển.",
				'hh_p_amenities_in'  => "Hồ bơi vô cực view biển\nPhòng gym\nSpa\nPhòng yoga\nTrung tâm thương mại khối đế\nNhà hàng, café\nKhu vui chơi trẻ em\nKhông gian sinh hoạt cộng đồng\nCông viên nội khu\nAn ninh 24/7",
				'hh_p_progress'      => "23/5/2025 | Tái khởi công dự án\nTháng 11/2025 | Mở bán tòa CT7 (kế hoạch)\nCuối 2026 | Bàn giao tòa CT1, CT2 (dự kiến)\nĐầu 2027 | Bàn giao tòa CT3, CT7 (dự kiến)",
			),
			'sources' => array(
				'https://thuvienphapluat.vn/phap-luat-nha-dat/tong-quan-ve-du-an-time-square-da-nang-chi-tiet-nhat-10317.html',
				'https://duandanang.com/thong-tin-du-an-times-square-da-nang-moi-nhat-2025/',
				'https://duanbdsdanang.com/du-an/times-square/',
			),
		),

		'capital-square-da-nang' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Capital Square Đà Nẵng tọa lạc trên đường Trần Hưng Đạo, phường An Hải Bắc (cũ), Sơn Trà, ven sông Hàn. Khu đất được bao quanh bởi 3 mặt tiền Trần Hưng Đạo, Ngô Quyền và Nguyễn Công Trứ, liền kề TTTM Vincom.",
				'hh_p_connections'   => "3 – 5 phút (khoảng 1,5 km) | Cầu Rồng",
				'hh_p_amenities_in'  => "Hồ bơi bốn mùa\nSky lounge\nVườn treo\nTrung tâm thương mại 2 tầng\nPhòng gym, yoga\nSpa, sauna\nSân thể thao đa năng\nKhu tập luyện ngoài trời\nĐường dạo bộ nội khu\nNhà trẻ\nNhà hàng",
				'hh_p_progress'      => "Tháng 3/2025 | Khởi công Capital Square 3\nQuý 1/2027 | Bàn giao (dự kiến, tùy tòa có thể đến 2028)",
			),
			'sources' => array(
				'https://brgvietnam.com/brg-capital-square/',
				'https://capitalsquaredanang.net/tien-do-capital-square/',
				'https://capitalsquarebrg.com.vn/',
			),
		),

		'newtown-diamond-da-nang' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Newtown Diamond nằm tại ngã tư Trường Sa – Nam Kỳ Khởi Nghĩa, phường Hòa Hải (cũ), Ngũ Hành Sơn, trên trục ven biển Đà Nẵng. Dự án đối diện Sheraton Grand Đà Nẵng Resort và liền kề BRG Đà Nẵng Golf Resort.",
				'hh_p_connections'   => "1 phút | Bãi biển\n5 phút | Danh thắng Ngũ Hành Sơn\nKhoảng 14 km | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in'  => "Hai hồ bơi vô cực tại tầng 6\nPhòng gym hiện đại\nSpa\nKhu vui chơi trẻ em\nVườn cảnh quan\n6 tầng trung tâm thương mại\nNhà trẻ",
				'hh_p_amenities_out' => "Sheraton Grand Đà Nẵng Resort\nBRG Đà Nẵng Golf Resort",
				'hh_p_progress'      => "18/4/2026 | Cất nóc tòa The Ruby\nQuý 3/2026 | Bàn giao (dự kiến)",
			),
			'sources' => array(
				'https://vnexpress.net/newtown-diamond-cat-noc-toa-can-ho-dau-tien-5065074.html',
				'https://tienphong.vn/newtown-diamond-cat-noc-toa-the-ruby-nang-tam-gia-tri-doc-ban-du-an-ven-bien-da-nang-post1837378.tpo',
				'https://hbcg.vn/news/10768-hoabinhchinhthuccatnoctoarubythuocduannewtowndiamond.html',
				'https://vn.savills.com.vn/residential/da-nang-projects/newtown-diamond.aspx',
				'https://southern.vn/du-an/newtown-diamond/',
			),
		),

		'fpt-plaza-1' => array(
			'meta'    => array(
				'hh_p_location_desc' => "FPT Plaza 1 nằm trên đường Võ Quý Huân, trong Khu đô thị công nghệ FPT City, phường Hòa Hải (cũ), Ngũ Hành Sơn. Tòa nhà gồm 1 tầng hầm, 15 tầng nổi với 586 căn hộ.",
				'hh_p_amenities_in'  => "Hồ bơi tràn bờ\nCông viên thông tầng\nPhòng tập gym, yoga, zumba\nKhu vui chơi trẻ em\nNhà hàng, café\nKhu mua sắm, cửa hàng",
				'hh_p_amenities_out' => "Liền kề 2 sân golf quốc tế và các khu nghỉ dưỡng ven biển\nHệ thống trường học FPT từ mầm non đến đại học\nFPT Complex, chợ, bệnh viện",
				'hh_p_progress'      => "2019 | Khởi công\nTháng 3/2022 | Bàn giao",
			),
			'sources' => array(
				'https://fptcity.vn/du-an/fpt-plaza-1/',
				'https://batdongsandanang.com.vn/chi-tiet-du-an/fpt-plaza-1-da-nang/',
			),
		),

		'fpt-plaza-2' => array(
			'meta'    => array(
				'hh_p_location_desc' => "FPT Plaza 2 nằm ở vị trí trung tâm Khu đô thị công nghệ FPT City, trên đường Võ Chí Công, Ngũ Hành Sơn. Khu đô thị nằm phía Nam thành phố, cách trung tâm Đà Nẵng và sân bay khoảng 10 phút đi xe.",
				'hh_p_connections'   => "10 phút | Trung tâm TP. Đà Nẵng\n10 phút | Sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in'  => "Bể bơi bốn mùa tại tầng 2\nPhòng gym, yoga, fitness\nSân vườn trung tâm\n2 tầng thương mại – dịch vụ\nSiêu thị mini\nNhà hàng, café\nNhà trẻ\nSalon, spa",
				'hh_p_amenities_out' => "Công viên trung tâm 3 ha với đường dạo bộ, khu BBQ, sân thể thao",
				'hh_p_progress'      => "Tháng 6/2023 | Bàn giao",
			),
			'sources' => array(
				'https://cvr.com.vn/vi/tong-quan-du-an-fpt-plaza-2-da-nang',
				'https://rever.vn/du-an/fpt-plaza-2',
				'https://hoanggiaminh.com/tin-tuc/vi-tri-fpt-plaza-2-o-dau-co-tiem-nang-gi.html',
			),
		),

		'fpt-plaza-3' => array(
			'meta'    => array(
				'hh_p_location_desc' => "FPT Plaza 3 nằm trong Khu đô thị công nghệ FPT City, Ngũ Hành Sơn, thừa hưởng hệ sinh thái trường học, công viên và tiện ích của khu đô thị. Tòa nhà cao 25 tầng nổi, 2 tầng hầm với 837 căn hộ sở hữu lâu dài.",
				'hh_p_amenities_in'  => "Bể bơi trong nhà tại tầng 3\nPhòng gym, yoga, fitness\nSảnh sinh hoạt chung\nKhu thương mại – dịch vụ khối đế",
				'hh_p_amenities_out' => "Hệ thống trường FPT từ mầm non đến đại học\nTiện ích chung của Khu đô thị FPT City",
				'hh_p_progress'      => "17/4/2026 | Khánh thành và bàn giao căn hộ",
			),
			'sources' => array(
				'https://doanhnghieptiepthi.vn/da-nang-khanh-thanh-fpt-plaza-3-va-ban-giao-can-ho-cho-khach-hang-161260413174758653.htm',
				'https://fptplaza3.fptcity.vn/tien-do/',
				'https://toprealty.vn/du-an/can-ho-fpt-plaza-3-da-nang/',
			),
		),

		'fpt-plaza-4' => array(
			'meta'    => array(
				'hh_p_location_desc' => "FPT Plaza 4 nằm tại lô B5-3, đường Hoàng Minh Thắng, Khu đô thị công nghệ FPT City, Ngũ Hành Sơn. Dự án quy mô khu đất khoảng 18.905 m² với 1.395 căn hộ.",
				'hh_p_amenities_in'  => "Khu thương mại – dịch vụ\nShophouse khối đế\nHệ tiện ích nội khu cho cư dân mọi lứa tuổi",
				'hh_p_progress'      => "19/3/2025 | Khởi công (tổng thầu Central)\nTháng 7/2025 | Gần hoàn thiện phần móng, đóng nắp hầm\nTháng 12/2026 | Cất nóc (kế hoạch)\nQuý 2/2027 | Đưa vào sử dụng (cam kết của chủ đầu tư)",
			),
			'sources' => array(
				'https://thanhnien.vn/khoi-cong-du-an-toa-nha-chung-cu-fpt-plaza-4-185250321084843137.htm',
				'https://tuoitre.vn/plo/khoi-cong-du-an-chung-cu-fpt-plaza-4-quy-mo-hon-2700-ti-dong-post839639.html',
				'https://www.xn--cnhfptplaza4-ynb8408h.vn/tien-do-xay-dung',
			),
		),

		'fpt-plaza-5' => array(
			'meta'    => array(
				'hh_p_location_desc' => "FPT Plaza 5 nằm trên đường Trần Quốc Vượng (đi vào từ Võ Chí Công), trong Khu đô thị FPT City phía Nam Đà Nẵng, gần FPT Complex và trường liên cấp FPT. Vị trí cách sân bay quốc tế và trung tâm thành phố khoảng 10 phút xe hơi.",
				'hh_p_connections'   => "10 phút | Sân bay quốc tế Đà Nẵng\n10 phút | Trung tâm TP. Đà Nẵng",
				'hh_p_amenities_in'  => "Hồ bơi\nSky garden\nPhòng gym\nShophouse\nKhuôn viên cây xanh\nKhu vui chơi trẻ em\nAn ninh 24/24",
				'hh_p_amenities_out' => "Sân golf The Dunes, Montgomerie Links\nCác resort ven biển (Ocean Villas, Furama Villas)\nFPT Complex, trường liên cấp FPT",
			),
			'sources' => array(
				'https://fpt-plaza5.com/',
				'https://fptcity.vn/vi-tri/',
			),
		),

		'the-sonata-sun-symphony' => array(
			'meta'    => array(
				'hh_p_location_desc' => "The Sonata là phân khu thấp tầng rộng 3 ha thuộc Sun Symphony Residence, nằm bên bờ sông Hàn trên trục Trần Hưng Đạo – Lê Văn Duyệt, Sơn Trà. Kiến trúc lấy cảm hứng từ thương cảng Hội An xưa với mái ngói đỏ, cổng vòm, mái hiên rộng.",
				'hh_p_amenities_in'  => "Bến du thuyền nội khu (3 bến)\nCông viên trung tâm Central Park 5.000 m²\nĐường dạo bộ ven sông Hàn\nHồ bơi vô cực\nPhòng gym\nKids club\nSpa cao cấp",
			),
			'sources' => array(
				'https://vietnamnet.vn/the-sonata-song-tan-huong-tai-toa-do-quoc-te-ben-song-han-2348982.html',
				'https://cafeland.vn/du-an/phan-khu-the-sonata-sun-symphony-residences-da-nang-4722.html',
				'https://congly.com.vn/the-sonata-ra-mat-phan-khu-dang-cap-nhat-tai-sun-symphony-residence/',
			),
		),

		'the-rio-sun-ponte' => array(
			'meta'    => array(
				'hh_p_location_desc' => "The Rio là phân khu thấp tầng của Sun Ponte Residence, nằm trực diện sông Hàn và kề cầu Rồng, trên trục Trần Hưng Đạo, Sơn Trà. Phân khu gồm 41 nhà phố cao 6,5 tầng và các căn biệt thự 3,5 tầng.",
				'hh_p_connections'   => "Kề cầu | Cầu Rồng",
				'hh_p_amenities_in'  => "Dùng chung tiện ích Sun Ponte Residence: hồ bơi\nPhòng gym, yoga\nSpa\nKids club\nKhông gian sinh hoạt cộng đồng\nĐường dạo ven sông Hàn",
			),
			'sources' => array(
				'https://royaland.com.vn/du-an/the-rio-du-an-sun-ponte-residences-da-nang.htm',
				'https://e.vnexpress.net/photo/vietnamproperty/sun-ponte-residence-after-two-years-of-construction-5086492.html',
			),
		),

		'hoiana-residences' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Hoiana Residences nằm tại thôn Tây Sơn Tây, xã Duy Hải, Duy Xuyên (Quảng Nam cũ), trong quần thể Hoiana Resort & Golf. Dự án gồm 2 tòa với 270 căn hộ khách sạn, nhiều căn hướng biển.",
				'hh_p_connections'   => "15 phút | Phố cổ Hội An\n20 phút | Biển Cửa Đại\n30 phút | Danh thắng Ngũ Hành Sơn\n50 phút | Trung tâm TP. Đà Nẵng, sân bay quốc tế Đà Nẵng",
				'hh_p_amenities_in'  => "Hồ bơi vô cực\nNhà hàng\nSpa\nPhòng gym\nBeach club\nKhu vui chơi trẻ em\nTrung tâm thể thao\nTrung tâm mua sắm\nSân golf Hoiana Shores Golf Club, club house",
			),
			'sources' => array(
				'https://blog.rever.vn/thong-tin-hoiana-residences',
				'https://rever.vn/du-an/hoiana-residences',
			),
		),

		'casamia-balanca-hoi-an' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Casamia Balanca (Khu đô thị Cồn Tiến) nằm tại xã Cẩm Thanh, Hội An (Quảng Nam cũ), giữa rừng dừa Bảy Mẫu thuộc Khu dự trữ sinh quyển thế giới Cù Lao Chàm – Hội An. Dự án tiếp giáp trục Võ Chí Công nối Đà Nẵng – Hội An – sân bay Chu Lai, quy mô 31,1 ha và có dòng sông tự nhiên nội khu.",
				'hh_p_amenities_in'  => "Bến du thuyền\nClubhouse\nNhà hàng\nSpa\nPhòng gym\nSân thể thao\nKhu vui chơi, vận động cho trẻ em\nCông viên cây xanh\nBungalow\nTrung tâm thương mại, trung tâm hội nghị\nTrường mầm non quốc tế\nKhách sạn",
				'hh_p_progress'      => "2022 | Khởi công hạ tầng\nQuý 3/2025 | Mở bán (dự kiến theo chủ đầu tư)\n2025 – 2026 | Bàn giao (dự kiến)",
			),
			'sources' => array(
				'https://homedy.com/casamia-balanca-hoi-an-khu-do-thi-con-tien-pj67242365',
				'https://tapchicongthuong.vn/tap-doan-dat-phuong--dpg--cho-doi--cu-hich--tu-du-an-casamia-balanca-127046.htm',
				'https://www.firhouse.vn/du-an/du-an-casamia-balanca-hoi-an.html',
			),
		),

		'casamia-calm-hoi-an' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Casamia Calm nằm tại xã Cẩm Hà, Hội An (Quảng Nam cũ), bên bờ sông Cổ Cò, cách phố cổ Hội An khoảng 2 km. Khu biệt thự rộng 6,4 ha với 112 căn đơn lập, cây xanh và mặt nước chiếm khoảng 70% diện tích; xung quanh là các làng nghề Trà Quế, làng lụa, làng gốm Thanh Hà.",
				'hh_p_connections'   => "Khoảng 2 km | Phố cổ Hội An\n4 – 6 km | Biển An Bàng, biển Cửa Đại",
				'hh_p_amenities_in'  => "Hơn 30 tiện ích nội khu\nHệ thống đảo giải trí dành riêng cho cư dân\nSông Cổ Cò bao quanh dự án\nMảng xanh, mặt nước chiếm khoảng 70% diện tích",
				'hh_p_amenities_out' => "Làng rau Trà Quế\nLàng gốm Thanh Hà\nLàng lụa Hội An",
			),
			'sources' => array(
				'https://cafeland.vn/du-an/casamia-calm-hoi-an-du-an-khu-biet-thu-tai-quang-nam-3942.html',
				'https://meeymap.com/tin-tuc/khu-do-thi-casamia-calm-hoi-an',
				'https://www.firhouse.vn/du-an/casamia-calm-hoi-an.html',
			),
		),

		'casamia-hoi-an' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Casamia Hội An tọa lạc tại thôn Võng Nhi, xã Cẩm Thanh, Hội An (Quảng Nam cũ), trong vùng rừng dừa Bảy Mẫu thuộc Khu dự trữ sinh quyển thế giới, gần phố cổ Hội An. Khu đô thị sinh thái rộng 15,6 ha gồm 216 biệt thự và nhà phố vườn, chia 3 phân khu Casa Rivana, Casa Vela và Casa Gala.",
				'hh_p_connections'   => "Khoảng 10 phút | Phố cổ Hội An\nKhoảng 10 phút | Biển An Bàng",
				'hh_p_amenities_in'  => "Bến du thuyền\nHồ bơi ngoài trời lớn\nClubhouse\nNhà hàng\nPhòng gym",
				'hh_p_progress'      => "Quý 4/2020 | Hoàn thành, bàn giao",
			),
			'sources' => array(
				'https://vnexpress.net/bat-dong-san/du-an/detail/casamia-hoi-an-56',
				'https://vtnarchitects.net/casamia-hoi-an-p185.html',
				'https://minhminhgroup.vn/casamia-hoi-an-khu-do-thi-sinh-thai-xung-tam-tinh-hoa-ben-thanh-pho-di-san/',
			),
		),

		'hoiana-beach-villas' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Hoiana Beach Villas là cụm biệt thự biển biệt lập trong quần thể Hoiana Resort & Golf, Duy Xuyên (Quảng Nam cũ), nay thuộc TP. Đà Nẵng. Phân khu rộng 36,6 ha, mật độ xây dựng khoảng 12%, sở hữu khoảng 700 m đường bờ biển và cách phố cổ Hội An khoảng 15 phút.",
				'hh_p_connections'   => "15 phút | Phố cổ Hội An",
				'hh_p_amenities_in'  => "3 hồ bơi lớn\nHồ bơi vô cực ven biển\nGym và phòng yoga sát biển\nTrung tâm spa & wellness\nSân pickleball\nSân golf 18 lỗ do Robert Trent Jones Jr. thiết kế\nTrung tâm giải trí (karaoke, bowling, billiards, golf 3D, kids club) mở từ 02/2026\nSảnh đón và lối vào riêng\nConcierge 24/7, an ninh 24/7\nMỗi biệt thự có vườn, hồ bơi riêng và 1 – 2 chỗ đỗ xe",
				'hh_p_progress'      => "Quý 1/2028 | Bàn giao (dự kiến)",
			),
			'sources' => array(
				'https://www.hoiana.com/hoiana-beach-villas',
				'https://cafef.vn/landcorp-la-dai-ly-phan-phoi-chinh-thuc-du-an-hoiana-beach-villas-188260525151902365.chn',
				'https://cvr.com.vn/vi/project/hoiana-beach-villas',
			),
		),

		'hoiana-shores-golf-villas' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Hoiana Shores Golf Villas nằm trong quần thể Hoiana Resort & Golf rộng khoảng 985 ha tại Duy Xuyên (Quảng Nam cũ), bên sân golf Hoiana Shores. Các biệt thự có diện tích đất khoảng 710 – 1.500 m².",
				'hh_p_amenities_in'  => "Sân golf Hoiana Shores chuẩn Championship\nClubhouse 6.000 m² (giải Best Golf Clubhouse thế giới 2020)\nNhà hàng Shores Café\nBãi biển, hồ bơi\nHệ thống khách sạn Hoiana Hotel & Suites, New World Hoiana, Rosewood Hội An\nNhà hàng, trung tâm mua sắm, tiện ích thể thao và giải trí của quần thể",
			),
			'sources' => array(
				'https://hoiana.com/vn/blog/hoiana-shores-golf-club/',
				'https://vars.com.vn/du-an-bds/hoiana-shores-golf-villas-p93',
				'https://lienkebietthu.com.vn/hoiana-shores-golf-villas/',
			),
		),

		'the-ocean-villas-da-nang' => array(
			'meta'    => array(
				'hh_p_location_desc' => "The Ocean Villas nằm trên đường Trường Sa, phường Hòa Hải (cũ), Ngũ Hành Sơn, trên tuyến ven biển nối Đà Nẵng với phố cổ Hội An. Khu nghỉ dưỡng rộng 21 ha với 115 biệt thự, hướng ra biển, sân golf và sông.",
				'hh_p_connections'   => "Khoảng 20 phút | Sân bay quốc tế Đà Nẵng\nKhoảng 15 phút | Phố cổ Hội An",
				'hh_p_amenities_in'  => "Bãi biển riêng\n2 hồ bơi lớn có khu dành cho trẻ em\nHồ bơi riêng tại mỗi biệt thự\nNhà hàng\nSpa\nBar bên biển, beach club\nPhòng gym\nKhu vui chơi trẻ em trong nhà và ngoài trời\nSân tennis",
				'hh_p_amenities_out' => "Sân golf do Greg Norman thiết kế (BRG Đà Nẵng Golf Resort)",
			),
			'sources' => array(
				'https://cvr.com.vn/vi/project/the-ocean-villas-resort-da-nang',
				'https://toprealty.vn/du-an/the-ocean-villas-da-nang/',
				'https://theoceanvillas.com.vn/location-map/',
			),
		),

		'nam-hoi-an-city' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Nam Hội An City nằm ven sông Thu Bồn, phía Nam chân cầu Cửa Đại, xã Duy Nghĩa, Duy Xuyên (Quảng Nam cũ), quy mô 19,34 ha. Dự án phía Bắc giáp sông Thu Bồn, phía Đông giáp cầu Cửa Đại và đường ven biển 129, phía Nam giáp đường Duy Thành – Duy Nghĩa.",
				'hh_p_connections'   => "Chân cầu | Cầu Cửa Đại\n15 phút | Biển Cửa Đại\n20 phút (khoảng 5 km) | Phố cổ Hội An",
				'hh_p_amenities_in'  => "Công viên ven sông\nPhố đi bộ ven sông\nBến du thuyền\nTrung tâm thương mại\nTrường mẫu giáo\nNhà sinh hoạt khối phố\nNhà hàng, café\nSpa",
			),
			'sources' => array(
				'https://www.fvg.com.vn/linh-vuc-hoat-dong/bat-dong-san/du-an-nam-hoi-an-city-/du-an-nam-hoi-an-city-.html',
				'https://homedy.com/nam-hoi-an-city-pj57643286',
				'https://toprealty.vn/du-an/nam-hoi-an-city/',
			),
		),

		'fpt-city-da-nang' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Khu đô thị FPT City nằm trên đường Võ Chí Công, phường Hòa Hải (cũ), Ngũ Hành Sơn, phía Nam TP. Đà Nẵng, giáp ranh Quảng Nam (cũ) và cạnh sông Cổ Cò. Khu đô thị rộng 181,6 ha, kết nối các trục Lê Văn Hiến, Trần Đại Nghĩa, Nam Kỳ Khởi Nghĩa, Võ Chí Công.",
				'hh_p_connections'   => "Khoảng 3 phút (800 m) | Biển Non Nước\n10 phút | Sân bay quốc tế Đà Nẵng\n20 phút | Phố cổ Hội An",
				'hh_p_amenities_in'  => "Hơn 100 ha công viên, cây xanh, mặt nước (kênh đào, hồ nhân tạo)\nHệ thống trường FPT từ mầm non đến đại học\nFPT Complex\nCác tòa căn hộ FPT Plaza có hồ bơi, gym, thương mại khối đế",
				'hh_p_amenities_out' => "Sân golf The Dunes, Montgomerie Links\nCác resort ven biển (Ocean Villas, Furama Villas)\nTrường quốc tế, bệnh viện đa khoa",
			),
			'sources' => array(
				'https://fptcity.vn/vi-tri/',
				'https://batdongsan.com.vn/du-an-khu-do-thi-moi-ngu-hanh-son-ddn/fpt-city-da-nang-pj769',
				'https://homedy.com/khu-do-thi-fpt-city-da-nang-pj99203614',
			),
		),

		'dragon-smart-city' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Dragon Smart City nằm trên đường số 5, cạnh tuyến Nguyễn Tất Thành nối dài, phường Hòa Hiệp Nam (cũ), Liên Chiểu, giữa hai khu đô thị Lakeside Palace và Golden Hill. Phía Đông hướng về Quốc lộ 1A và biển Xuân Thiều, phía Tây là Khu công nghệ cao Đà Nẵng; quy mô khoảng 78 ha.",
				'hh_p_amenities_in'  => "Hồ nước sinh thái hình thân rồng ở trung tâm\nClubhouse\nTrường học quốc tế\nSiêu thị\nTrung tâm văn hóa – thể dục thể thao\nHơn 20 tiểu công viên và 2 công viên chủ đề",
				'hh_p_amenities_out' => "Biển Xuân Thiều\nKhu công nghệ cao Đà Nẵng",
			),
			'sources' => array(
				'https://datxanhmientrung.com/hon-nghin-khach-hang-tham-du-le-ra-mat-du-an-dragon-smart-city',
				'https://homedy.com/dragon-city-park-pj72817538',
				'https://batdongsanocn.com/du-an/du-an-dragon-smart-city-da-nang/',
			),
		),

		'lakeside-palace' => array(
			'meta'    => array(
				'hh_p_location_desc' => "Lakeside Palace nằm tại phường Hòa Hiệp Nam (cũ), Liên Chiểu, ở giao điểm hai trục Nguyễn Lương Bằng và đường số 5. Dự án nhìn trực diện hồ điều tiết Bàu Tràm rộng khoảng 60 ha.",
				'hh_p_connections'   => "3 phút | Đại học Sư phạm, Đại học Bách khoa\n7 phút | Trung tâm hành chính quận Liên Chiểu (cũ), bệnh viện đa khoa\n15 phút | Sân bay quốc tế Đà Nẵng, cầu Rồng, sông Hàn",
				'hh_p_amenities_in'  => "Công viên nội khu 3.000 m²\nHồ sinh thái, kênh sinh thái\nCông viên tuyến tính (Linear Park)\nĐường dạo ven hồ\nLakeside Plaza\nBệnh viện quốc tế đa khoa\nNhà trẻ, mẫu giáo, trường tiểu học quốc tế\nSân thể thao, sân chơi trẻ em\nNhà chờ xe buýt BRT\nChốt an ninh 24/24",
				'hh_p_amenities_out' => "Hồ điều tiết Bàu Tràm\nĐại học Sư phạm, Đại học Bách khoa Đà Nẵng",
			),
			'sources' => array(
				'https://betaviet.vn/khu-do-thi/lakeside-palace/',
				'https://nhadat.cafeland.vn/ban-du-an/lakeside-palace-1786/',
				'https://batdongsandanang.com.vn/chi-tiet-du-an/lakeside-palace-da-nang/',
			),
		),

		'one-world-regency' => array(
			'meta'    => array(
				'hh_p_location_desc' => "One World Regency nằm trong Khu đô thị mới Điện Nam – Điện Ngọc, Điện Bàn (Quảng Nam cũ), cách ranh giới Đà Nẵng khoảng 800 m. Dự án nằm ven sông Cổ Cò, hướng về sân golf Đà Nẵng và đối diện khu nghỉ dưỡng – giải trí Cocobay.",
				'hh_p_connections'   => "Khoảng 800 m | Ranh giới TP. Đà Nẵng (cũ)\nKhoảng 20 phút | Phố cổ Hội An",
				'hh_p_amenities_in'  => "Phố đi bộ ven sông Cổ Cò\nBến du thuyền\nHai công viên trung tâm và nhiều công viên cây xanh\nQuảng trường ven sông\nTrung tâm thương mại khoảng 4.000 m²\nSiêu thị, nhà hàng, cửa hàng tiện lợi\nKhách sạn\nXe đưa đón sân bay",
				'hh_p_amenities_out' => "Sân golf Đà Nẵng\nKhu nghỉ dưỡng – giải trí Cocobay",
			),
			'sources' => array(
				'https://nhadat.cafeland.vn/du-an-one-world-regency-dat-nen-ven-bien-da-nangcua-tap-doan-dat-xanh-mien-trung-1311366.html',
				'https://guland.vn/du-an/one-world-regency',
				'https://batdongsanocn.com/du-an/du-an-one-world-regency/',
			),
		),

	);
}
