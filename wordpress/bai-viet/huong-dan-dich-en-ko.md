# Hướng dẫn dịch EN / KO – hiephoangmt.com

Dùng chung cho mọi bảng dịch trong `wordpress/wp-content/mu-plugins/hh-crm/tr/` để các trang dịch đồng bộ.

## Định dạng file

- `tr/chung.json`: nhãn dùng chung, gồm nút, menu, biểu mẫu và tiêu đề mục.
- `tr/trang-chu.json`: trang chủ.
- `tr/luu-tru-du-an.json`: trang danh sách dự án.
- `tr/du-an/<slug>.json`: từng trang dự án.
- `tr/post/<slug>.json`: bài viết.

Nội dung file: `{ "đoạn chữ tiếng Việt y nguyên": ["English", "한국어"] }`.

- Khóa (key) là đúng đoạn chữ hiển thị trên trang, đã gộp khoảng trắng. Không sửa khóa.
- Ô để `""` thì ngôn ngữ đó để Google dịch.
- Đoạn chữ có thể là mảnh câu, vì một câu có chữ in đậm hoặc liên kết bị tách thành nhiều đoạn. Vẫn dịch đúng nghĩa của mảnh đó, đầu và cuối giữ khoảng trắng hoặc dấu câu y như bản gốc để ghép lại vẫn tự nhiên.

## Giọng văn

- Tư vấn bất động sản chuyên nghiệp, ngắn gọn, rõ ràng.
- Tiếng Anh: chuẩn Anh – Mỹ thông dụng cho người nước ngoài mua nhà.
- Tiếng Hàn: văn phong 합니다/입니다 lịch sự, kiểu trang môi giới bất động sản Hàn Quốc.
- Ngôi xưng: "Hiệp" / "Hoàng Hiệp" → EN "Hiep" / "Hoang Hiep", KO "히엡" / "호앙 히엡". Không dùng "I" thay cho Hiệp nếu bản gốc dùng tên.
- "anh/chị", "bạn" → EN "you", KO "고객님".

## Thuật ngữ bắt buộc

| Tiếng Việt | English | 한국어 |
|---|---|---|
| căn hộ | apartment | 아파트 |
| căn (đơn vị chung) | unit | 세대 / 호실 |
| biệt thự | villa | 빌라 |
| nhà phố / liền kề | townhouse | 타운하우스 |
| shophouse / shop khối đế | shophouse / podium shop | 샵하우스 / 포디움 상가 |
| đất nền | land plot | 토지(필지) |
| condotel / căn hộ dịch vụ | condotel / serviced apartment | 콘도텔 / 서비스 아파트 |
| chủ đầu tư | developer | 시행사 |
| đơn vị vận hành | operator | 운영사 |
| mở bán | sales launch / on sale | 분양 |
| chuyển nhượng | resale | 전매 |
| cho thuê | rent / rental | 임대 |
| ký gửi | consignment (list with us) | 위탁(매물 등록) |
| giỏ hàng | available units | 매물 목록 |
| bảng giá | price list | 분양가표 |
| chính sách bán hàng | sales policy | 분양 정책 |
| chiết khấu | discount | 할인 |
| thanh toán sớm | early payment | 조기 납부 |
| đặt cọc | deposit | 계약금 |
| giữ chỗ | booking | 예약 |
| bàn giao | handover | 인도(입주) |
| tiêu chuẩn bàn giao | handover standard | 인도 기준 |
| sổ hồng | Pink Book (ownership certificate) | 핑크북(소유권 증서) |
| sổ đỏ | Red Book (land use right certificate) | 레드북(토지사용권 증서) |
| sở hữu lâu dài | freehold (long-term ownership) | 영구 소유 |
| 50 năm | 50-year leasehold | 50년 소유 |
| pháp lý | legal status | 법적 상태 |
| hợp đồng mua bán | sale and purchase agreement (SPA) | 매매계약서(SPA) |
| diện tích thông thủy / tim tường | net area / gross area | 전용면적 / 공급면적 |
| mặt bằng (tầng / tổng thể) | floor plan / master plan | 평면도 / 마스터플랜 |
| tiện ích nội khu / ngoại khu | on-site / nearby amenities | 단지 내 / 주변 편의시설 |
| quy mô | site area / scale | 대지 규모 |
| mật độ xây dựng | building density | 건폐율 |
| tiến độ | construction progress | 공사 진행 |
| phối cảnh | rendering | 조감도 / 투시도 |
| ảnh thực tế | actual photo | 실사 |
| tỷ (tiền) | billion VND (e.g. "39 billion VND") | 억 동 (39 tỷ = 390억 동) |
| triệu (tiền) | million VND | 만 동 (80 triệu = 8,000만 동) |
| khoảng / chỉ từ | about / from | 약 / ~부터 |
| tham khảo | for reference | 참고 |

## Địa danh, tên riêng

- Tiếng Anh: viết không dấu, theo cách người nước ngoài quen dùng.
  - "đường Võ Nguyên Giáp" → "Vo Nguyen Giap Street".
  - "phường Mỹ An" → "My An Ward". "quận Sơn Trà" → "Son Tra District".
  - "(cũ)" → "(former)".
- Tiếng Hàn: phiên âm quen dùng, kèm tên Latin khi là tên đường.
  - Ví dụ: 보응우옌잡 거리(Vo Nguyen Giap St.).
- Địa danh cố định:

| Tiếng Việt | English | 한국어 |
|---|---|---|
| Đà Nẵng | Da Nang | 다낭 |
| Hội An | Hoi An | 호이안 |
| sông Hàn | Han River | 다낭 한강 (luôn ghi "다낭" để không nhầm sông Hàn ở Seoul) |
| cầu Rồng | Dragon Bridge | 용다리 |
| cầu sông Hàn | Han River Bridge | 다낭 한강교 |
| cầu Trần Thị Lý | Tran Thi Ly Bridge | 쩐티리 다리 |
| biển Mỹ Khê | My Khe Beach | 미케 비치 |
| bán đảo Sơn Trà | Son Tra Peninsula | 선짜 반도 |
| Ngũ Hành Sơn | Marble Mountains (Ngu Hanh Son) | 오행산 |
| Bà Nà | Ba Na Hills | 바나힐 |
| phố cổ Hội An | Hoi An Ancient Town | 호이안 올드타운 |
| sân bay quốc tế Đà Nẵng | Da Nang International Airport | 다낭 국제공항 |
| chợ Hàn | Han Market | 한시장 |
| phố An Thượng | An Thuong street | 안트엉 거리 |
| pháo hoa DIFF | DIFF fireworks festival | 다낭 국제 불꽃축제(DIFF) |

- Tên dự án, thương hiệu, tên nhà hàng giữ nguyên chữ Latin ở cả hai thứ tiếng. Ví dụ: Sun Group, Premier Village, Sun Symphony Residence, Cá Chuồn Cồ → "Ca Chuon Co".
- Không dịch số điện thoại, Zalo, email, đường dẫn web.

## Số, đơn vị, ngày

- m², ha, km giữ nguyên. "15 ha" → EN "15 ha", KO "15헥타르".
- Ngày "30/06/2028":
  - EN: "June 30, 2028".
  - KO: "2028년 6월 30일".
- "Quý 4/2027":
  - EN: "Q4 2027".
  - KO: "2027년 4분기".
- "11/2026":
  - EN: "November 2026".
  - KO: "2026년 11월".
- Số thập phân: EN dùng dấu chấm ("2.73 billion VND"), KO dùng dấu chấm và đơn vị 억 ("27억 3천만 동").
