# Dữ liệu trang "Vé tham quan" – sinh ra vi.html và ko.html (chạy: python3 du_lieu.py)
# Không ghi giá vé cố định: giá thay đổi theo mùa, Vân Trần báo giá trong ngày.
import html, os

ZALO = "https://zalo.me/0909669325"

A = [
  # ---------------- ĐÀ NẴNG ----------------
  dict(area="dn", vi=dict(
    name="Sun World Bà Nà Hills", where="Hòa Vang · cách trung tâm ~40 km",
    desc="Cáp treo vượt rừng lên đỉnh núi gần 1.500 m, Cầu Vàng với đôi bàn tay đá khổng lồ, Làng Pháp, vườn hoa Le Jardin d'Amour, hầm rượu Debay và khu vui chơi trong nhà Fantasy Park. Từ năm 2026, vé cáp treo dùng được tối đa 3 ngày liên tiếp.",
    time="Cả ngày (7–8 tiếng)", best="Sáng sớm ngày nắng, tránh cuối tuần và lễ", fit="Mọi lứa tuổi, gia đình, cặp đôi", move="Ô tô ~50 phút",
    tips=["Lên cáp treo từ 7–8 giờ để chụp Cầu Vàng trước khi mây và đoàn khách kéo đến.",
          "Trên đỉnh lạnh hơn thành phố 6–8°C, mùa đông có thể dưới 15°C — mang áo khoác.",
          "Vé có buffet trưa tiện hơn mua lẻ trên núi; mang nước và kem chống nắng.",
          "Sương mù dày thì gần như không thấy toàn cảnh — nên đổi ngày, chúng tôi tư vấn theo dự báo."],
    btn="Đặt vé Bà Nà"),
    ko=dict(name="썬월드 바나힐", where="호아방 · 시내에서 약 40km",
    desc="숲 위를 지나는 케이블카로 해발 약 1,500m 정상에 올라 거대한 손 조형물의 골든브릿지, 프렌치 빌리지, 르 자르댕 다무르 정원, 드베이 와인 저장고, 실내 놀이공원 판타지파크를 즐길 수 있습니다. 2026년부터 케이블카 티켓은 최대 3일 연속 사용 가능합니다.",
    time="하루 종일 (7–8시간)", best="맑은 날 이른 아침, 주말·공휴일 피하기", fit="전 연령, 가족, 커플", move="차량 약 50분",
    tips=["오전 7–8시에 케이블카를 타야 구름과 단체 관광객 전에 골든브릿지를 촬영할 수 있습니다.",
          "정상은 시내보다 6–8°C 낮고 겨울에는 15°C 아래로 내려가기도 하니 겉옷을 챙기세요.",
          "점심 뷔페 포함 티켓이 산 위에서 따로 사는 것보다 편합니다. 물과 선크림 필수.",
          "안개가 짙으면 전경이 거의 보이지 않으니 날짜 변경을 권합니다. 예보를 보고 안내해 드립니다."],
    btn="바나힐 예약")),

  dict(area="dn", vi=dict(
    name="Suối khoáng nóng Núi Thần Tài", where="Hòa Vang · cách trung tâm ~30 km",
    desc="Công viên suối khoáng nóng nằm giữa rừng, dưới chân núi Thần Tài: hồ ngâm khoáng nóng, tắm bùn khoáng, onsen kiểu Nhật, công viên nước, hồ tạo sóng và nhiều trò chơi cho trẻ em.",
    time="Nửa ngày đến cả ngày", best="Ngày se lạnh hoặc mưa nhẹ (tháng 11–2)", fit="Gia đình, người lớn tuổi, nhóm bạn", move="Ô tô ~40 phút",
    tips=["Mang đồ bơi, khăn, quần áo thay và túi đựng đồ ướt.",
          "Mỗi lần ngâm khoáng nóng chỉ nên 15–20 phút, uống đủ nước, nghỉ giữa các lượt.",
          "Người có bệnh tim mạch, huyết áp và phụ nữ mang thai nên hỏi ý kiến bác sĩ trước.",
          "Kết hợp được với Bà Nà trên cùng tuyến đường nếu đi 2 ngày liền."],
    btn="Đặt vé Núi Thần Tài"),
    ko=dict(name="탄따이 온천 (Núi Thần Tài)", where="호아방 · 시내에서 약 30km",
    desc="탄따이 산 아래 숲속에 자리한 온천 공원. 온천탕, 머드 온천, 일본식 온센, 워터파크, 파도풀과 어린이 놀이 시설이 있습니다.",
    time="반나절–하루", best="쌀쌀하거나 약한 비가 오는 날 (11–2월)", fit="가족, 어르신, 친구 여행", move="차량 약 40분",
    tips=["수영복, 수건, 갈아입을 옷과 젖은 옷 봉투를 준비하세요.",
          "온천은 한 번에 15–20분 정도만, 물을 충분히 마시고 쉬어 가며 이용하세요.",
          "심혈관 질환·고혈압이 있거나 임신 중이라면 미리 의사와 상담하세요.",
          "이틀 연속 일정이라면 같은 방향의 바나힐과 묶기 좋습니다."],
    btn="탄따이 온천 예약")),

  dict(area="dn", vi=dict(
    name="Khu du lịch sinh thái Suối Lương", where="Liên Chiểu · chân đèo Hải Vân",
    desc="Dòng suối đá trong vắt chảy từ núi xuống gần biển Nam Ô, hai bên là rừng và chòi nghỉ; tắm suối, dã ngoại và ăn các món dân dã như gà thả vườn, cá suối — điểm cuối tuần quen thuộc của người Đà Nẵng.",
    time="Nửa ngày", best="Mùa nắng tháng 4–8, buổi sáng", fit="Nhóm bạn, gia đình, dã ngoại", move="Ô tô ~30 phút",
    tips=["Mùa mưa (tháng 10–12) nước suối có thể dâng nhanh, khu du lịch có thể tạm dừng đón khách — luôn hỏi lịch mở cửa trước.",
          "Không xuống suối sau mưa lớn hoặc khi nước đục, chảy xiết.",
          "Mang dép quai hậu, đá suối rất trơn; trẻ em cần người lớn đi kèm.",
          "Kết hợp ngắm hoàng hôn ở đèo Hải Vân hoặc làng cá Nam Ô."],
    btn="Hỏi lịch mở cửa Suối Lương"),
    ko=dict(name="수이르엉 생태 관광지 (Suối Lương)", where="리엔찌에우 · 하이반 고개 아래",
    desc="산에서 남오 해변 쪽으로 흐르는 맑은 바위 계곡. 숲과 휴식 정자가 있어 계곡 물놀이, 피크닉, 토종닭·계곡 생선 같은 시골 음식을 즐길 수 있는 다낭 사람들의 주말 명소입니다.",
    time="반나절", best="건기 4–8월 오전", fit="친구, 가족, 피크닉", move="차량 약 30분",
    tips=["우기(10–12월)에는 계곡물이 빠르게 불어나 운영이 일시 중단될 수 있으니 미리 확인하세요.",
          "큰비 뒤나 물이 탁하고 빠를 때는 들어가지 마세요.",
          "바위가 매우 미끄러우니 뒤꿈치 끈 샌들을 신고, 아이는 보호자와 함께하세요.",
          "하이반 고개 일몰이나 남오 어촌과 함께 둘러보기 좋습니다."],
    btn="수이르엉 운영 문의")),

  dict(area="dn", vi=dict(
    name="Khu du lịch Hòa Phú Thành", where="Hòa Vang · cách trung tâm ~25 km",
    desc="Chèo thuyền hơi vượt thác (rafting) trên đoạn suối đá dài, đu dây zipline qua rừng, tắm suối và nhiều trò chơi vận động ngoài trời.",
    time="Nửa ngày", best="Mùa khô, nước suối vừa phải", fit="Nhóm bạn trẻ, team building", move="Ô tô ~40 phút",
    tips=["Trò vượt thác phụ thuộc lượng nước; mùa mưa lớn có thể tạm ngưng vì an toàn.",
          "Mặc đồ nhanh khô, dép quai hậu, kính có dây; mang túi chống nước cho điện thoại.",
          "Luôn mặc áo phao, đội mũ bảo hộ và nghe hướng dẫn viên trước khi xuống thuyền.",
          "Không phù hợp trẻ quá nhỏ và người có bệnh tim — hỏi điều kiện độ tuổi trước."],
    btn="Đặt vé Hòa Phú Thành"),
    ko=dict(name="호아푸타인 관광지", where="호아방 · 시내에서 약 25km",
    desc="긴 바위 계곡을 고무보트로 내려가는 래프팅, 숲 위 짚라인, 계곡 물놀이와 다양한 야외 액티비티.",
    time="반나절", best="건기, 수량이 적당할 때", fit="젊은 친구 그룹, 팀빌딩", move="차량 약 40분",
    tips=["래프팅은 수량에 따라 달라지며 큰비가 오면 안전을 위해 중단될 수 있습니다.",
          "속건 의류, 끈 샌들, 끈 달린 안경, 휴대폰 방수팩을 준비하세요.",
          "구명조끼와 헬멧을 반드시 착용하고 출발 전 안내를 들으세요.",
          "어린아이나 심장 질환이 있는 분에게는 맞지 않으니 연령 조건을 먼저 확인하세요."],
    btn="호아푸타인 예약")),

  dict(area="dn", vi=dict(
    name="Công viên nước Mikazuki", where="Liên Chiểu · đường Nguyễn Tất Thành",
    desc="Công viên nước phong cách Nhật Bản bên vịnh Đà Nẵng, có khu trong nhà, hồ tạo sóng, máng trượt và khu tắm onsen nước nóng.",
    time="Nửa ngày", best="Quanh năm, kể cả ngày mưa", fit="Gia đình có trẻ nhỏ", move="Ô tô ~20 phút",
    tips=["Lựa chọn tốt cho ngày mưa vì có khu trong nhà, nước ấm.",
          "Đi sáng ngày thường cho vắng; cuối tuần và hè rất đông.",
          "Nhiều khu yêu cầu đồ bơi đúng quy định — chuẩn bị sẵn để khỏi phải thuê.",
          "Khu onsen thường có quy định riêng (tắm tráng trước, không mang điện thoại)."],
    btn="Đặt vé Mikazuki"),
    ko=dict(name="미카즈키 워터파크", where="리엔찌에우 · 응우옌떳타인 거리",
    desc="다낭만 옆 일본풍 워터파크. 실내 구역, 파도풀, 슬라이드, 온천 온센 시설이 있습니다.",
    time="반나절", best="연중, 비 오는 날도 OK", fit="어린 자녀 동반 가족", move="차량 약 20분",
    tips=["실내·온수 구역이 있어 비 오는 날 좋은 선택입니다.",
          "평일 오전이 한산하며 주말과 여름에는 매우 붐빕니다.",
          "규정에 맞는 수영복이 필요한 구역이 많으니 미리 준비하세요.",
          "온센 구역은 샤워 후 입장, 휴대폰 반입 제한 등 별도 규칙이 있습니다."],
    btn="미카즈키 예약")),

  dict(area="dn", vi=dict(
    name="Công viên Châu Á (Asia Park) & Sun Wheel", where="Hải Châu · bên sông Hàn",
    desc="Công viên giải trí với tàu lượn, tháp rơi tự do, khu kiến trúc châu Á và vòng quay Sun Wheel nhìn toàn cảnh thành phố về đêm.",
    time="2–4 tiếng buổi tối", best="Hoàng hôn đến tối", fit="Gia đình, cặp đôi, nhóm bạn", move="Ô tô ~10 phút",
    tips=["Thường mở cửa từ chiều — kiểm tra giờ mở cửa và ngày nghỉ trước khi đi.",
          "Lên vòng quay lúc hoàng hôn để chụp sông Hàn và các cây cầu lên đèn.",
          "Trò cảm giác mạnh có giới hạn chiều cao, sức khỏe — xem kỹ quy định.",
          "Kết hợp xem cầu Rồng phun lửa 21:00 tối thứ Bảy, Chủ nhật."],
    btn="Đặt vé Asia Park"),
    ko=dict(name="아시아파크 & 썬휠", where="하이쩌우 · 한강변",
    desc="롤러코스터, 자이로드롭, 아시아 건축 테마 구역과 도시 야경을 내려다보는 대관람차 썬휠이 있는 놀이공원.",
    time="저녁 2–4시간", best="해 질 녘–저녁", fit="가족, 커플, 친구", move="차량 약 10분",
    tips=["보통 오후부터 운영하니 운영 시간과 휴무일을 미리 확인하세요.",
          "해 질 녘 썬휠에 오르면 불 켜진 한강과 다리를 찍을 수 있습니다.",
          "스릴 기구는 키·건강 제한이 있으니 규정을 확인하세요.",
          "토·일요일 밤 9시 용다리 불·물 쇼와 함께 일정 짜기 좋습니다."],
    btn="아시아파크 예약")),

  dict(area="dn", vi=dict(
    name="Danh thắng Ngũ Hành Sơn", where="Ngũ Hành Sơn · cách trung tâm ~8 km",
    desc="Năm ngọn núi đá vôi với hệ thống hang động như động Huyền Không, động Âm Phủ, chùa Tam Thai, chùa Linh Ứng; dưới chân núi là làng đá mỹ nghệ Non Nước. Có thang máy lên núi Thủy Sơn.",
    time="2–3 tiếng", best="Sáng sớm, đi được cả ngày mưa nhẹ", fit="Mọi lứa tuổi (dùng thang máy)", move="Ô tô ~15 phút",
    tips=["Đi lúc mở cửa cho mát và vắng; buổi trưa trong hang khá oi.",
          "Giày bám tốt, bậc đá cũ và trơn khi ẩm.",
          "Ăn mặc kín đáo khi vào chùa, giữ trật tự trong hang.",
          "Mua đồ đá ở Non Nước nên hỏi giá nhiều nơi và hỏi kỹ phí vận chuyển."],
    btn="Đặt vé & xe Ngũ Hành Sơn"),
    ko=dict(name="오행산 (마블 마운틴)", where="응우하인선 · 시내에서 약 8km",
    desc="다섯 개의 석회암 산에 후옌콩 동굴, 엄푸 동굴, 땀타이 사원, 린응사가 있고 산 아래에 논느억 석공예 마을이 있습니다. 투이선 산에는 엘리베이터가 있습니다.",
    time="2–3시간", best="이른 아침, 약한 비에도 가능", fit="전 연령 (엘리베이터 이용)", move="차량 약 15분",
    tips=["개장 시간에 가면 시원하고 한산합니다. 한낮 동굴 안은 덥습니다.",
          "오래된 돌계단은 젖으면 미끄러우니 접지력 좋은 신발을 신으세요.",
          "사원에서는 단정한 복장, 동굴 안에서는 정숙.",
          "논느억 석공예품은 여러 곳을 비교하고 배송비를 꼭 확인하세요."],
    btn="오행산 입장권·차량")),

  dict(area="dn", vi=dict(
    name="Bảo tàng Điêu khắc Chăm", where="Hải Châu · gần cầu Rồng",
    desc="Bảo tàng lâu đời với bộ sưu tập điêu khắc Chăm đặc sắc bậc nhất: tượng thần, phù điêu, bệ thờ từ các khu đền tháp miền Trung.",
    time="1,5–2 tiếng", best="Buổi sáng hoặc ngày mưa", fit="Người yêu lịch sử, văn hóa", move="Trung tâm thành phố",
    tips=["Nên có hướng dẫn viên hoặc thuyết minh để hiểu ý nghĩa từng hiện vật.",
          "Đi trước khi đến Mỹ Sơn sẽ giúp hiểu sâu hơn về văn hóa Chăm.",
          "Kết hợp dạo cầu Rồng, chợ Hàn gần đó."],
    btn="Đặt vé & hướng dẫn viên"),
    ko=dict(name="참 조각 박물관", where="하이쩌우 · 용다리 근처",
    desc="역사 깊은 박물관으로, 중부 지역 사원에서 온 신상, 부조, 제단 등 손꼽히는 참족 조각 컬렉션을 소장하고 있습니다.",
    time="1.5–2시간", best="오전 또는 비 오는 날", fit="역사·문화 애호가", move="시내 중심",
    tips=["가이드나 해설이 있으면 유물의 의미를 훨씬 잘 이해할 수 있습니다.",
          "미선 유적 방문 전에 들르면 참 문화를 더 깊이 알 수 있습니다.",
          "근처 용다리, 한시장과 함께 둘러보세요."],
    btn="입장권·가이드 예약")),

  dict(area="dn", vi=dict(
    name="Du thuyền sông Hàn", where="Sông Hàn · buổi tối",
    desc="Ngắm cầu Rồng, cầu Sông Hàn, cầu Trần Thị Lý lên đèn từ mặt sông; tối thứ Bảy, Chủ nhật có thể xem cầu Rồng phun lửa, phun nước lúc 21:00 ngay trên thuyền.",
    time="45–90 phút", best="Tối thứ Bảy, Chủ nhật", fit="Cặp đôi, gia đình, khách lớn tuổi", move="Bến thuyền trung tâm",
    tips=["Chọn chuyến khởi hành 20:00–20:30 cuối tuần để kịp cầu Rồng.",
          "Mang áo khoác mỏng, gió sông về đêm khá lạnh.",
          "Ngày gió mạnh hoặc mưa lớn có thể hủy chuyến — chúng tôi báo lại sớm."],
    btn="Đặt vé du thuyền"),
    ko=dict(name="한강 유람선", where="한강 · 저녁",
    desc="강 위에서 용다리, 한강교, 쩐티리 다리의 야경을 감상합니다. 토·일요일 밤에는 배 위에서 밤 9시 용다리 불·물 쇼를 볼 수 있습니다.",
    time="45–90분", best="토·일요일 저녁", fit="커플, 가족, 어르신", move="시내 선착장",
    tips=["주말에는 20:00–20:30 출발편을 타야 용다리 쇼를 볼 수 있습니다.",
          "밤 강바람이 쌀쌀하니 얇은 겉옷을 챙기세요.",
          "강풍이나 폭우 시 취소될 수 있으며 미리 알려 드립니다."],
    btn="유람선 예약")),

  dict(area="dn", vi=dict(
    name="Tour bán đảo Sơn Trà", where="Sơn Trà · cách trung tâm ~10 km",
    desc="Xe đưa đón lên chùa Linh Ứng Bãi Bụt, đỉnh Bàn Cờ, cây đa ngàn năm, các điểm ngắm vịnh; may mắn có thể gặp voọc chà vá chân nâu — loài linh trưởng quý hiếm.",
    time="Nửa ngày", best="Sáng sớm sau mưa", fit="Người yêu thiên nhiên, chụp ảnh", move="Ô tô ~20 phút",
    tips=["Đường đèo dốc, nhiều khúc cua — ngày mưa không nên tự chạy xe máy.",
          "Không cho voọc ăn, giữ yên lặng và khoảng cách khi quan sát.",
          "Mang nước, mũ; trên bán đảo ít hàng quán.",
          "Kết hợp ăn hải sản làng chài Mân Thái khi xuống núi."],
    btn="Đặt tour Sơn Trà"),
    ko=dict(name="선짜 반도 투어", where="선짜 · 시내에서 약 10km",
    desc="차량으로 린응사(바이붓), 반꺼 정상, 천년 반얀나무, 만 전망 포인트를 둘러보고, 운이 좋으면 희귀 영장류 붉은다리두크원숭이를 만날 수 있습니다.",
    time="반나절", best="비 온 뒤 이른 아침", fit="자연·사진 애호가", move="차량 약 20분",
    tips=["가파른 굽잇길이라 비 오는 날 직접 오토바이 운전은 피하세요.",
          "원숭이에게 먹이를 주지 말고 조용히 거리를 두고 관찰하세요.",
          "반도에는 상점이 적으니 물과 모자를 준비하세요.",
          "내려오는 길에 만타이 어촌 해산물 식사를 추천합니다."],
    btn="선짜 투어 예약")),

  # ---------------- HỘI AN ----------------
  dict(area="ha", vi=dict(
    name="Vé tham quan phố cổ Hội An", where="Phố cổ Hội An",
    desc="Vé vào khu phố cổ — Di sản văn hóa thế giới — kèm quyền tham quan một số nhà cổ, hội quán, bảo tàng và nhà thờ tộc theo quy định hiện hành.",
    time="Nửa ngày đến hết buổi tối", best="15:00–21:00, đêm rằm 14 âm lịch", fit="Mọi lứa tuổi", move="Ô tô ~45 phút từ Đà Nẵng",
    tips=["Đến khoảng 15–16 giờ, dạo trong nắng dịu rồi ở lại đến lúc đèn lồng lên.",
          "Giữ vé suốt thời gian tham quan, nhân viên có thể kiểm tra tại các lối vào.",
          "Mùa mưa lớn, vài tuyến phố sát sông Hoài có thể ngập — hỏi chúng tôi trước khi đi.",
          "Thả hoa đăng nên thống nhất giá trước; tôn trọng không gian của cư dân phố cổ."],
    btn="Đặt vé & xe đi Hội An"),
    ko=dict(name="호이안 구시가지 입장권", where="호이안 구시가지",
    desc="세계문화유산 구시가지 입장권으로, 현행 규정에 따라 일부 고가, 회관, 박물관, 사당을 관람할 수 있습니다.",
    time="반나절–저녁까지", best="15:00–21:00, 음력 14일 보름밤", fit="전 연령", move="다낭에서 차량 약 45분",
    tips=["오후 3–4시쯤 도착해 부드러운 햇살 속을 걷고 등불이 켜질 때까지 머무르세요.",
          "입구에서 확인할 수 있으니 관람하는 동안 티켓을 보관하세요.",
          "큰비가 오면 호아이강변 일부 거리가 침수될 수 있으니 미리 문의하세요.",
          "소원등 띄우기는 가격을 먼저 정하고, 주민 생활 공간을 존중해 주세요."],
    btn="호이안 입장권·차량")),

  dict(area="ha", vi=dict(
    name="Show Ký Ức Hội An", where="Công viên Ấn tượng Hội An · cồn Cẩm Nam",
    desc="Chương trình nghệ thuật thực cảnh quy mô lớn với hàng trăm diễn viên, tái hiện 400 năm lịch sử thương cảng Hội An trên sân khấu ngoài trời bên sông Hoài.",
    time="Khoảng 1 tiếng (cộng thời gian dạo công viên)", best="Buổi tối", fit="Gia đình, cặp đôi, khách quốc tế", move="Gần phố cổ",
    tips=["Ghế hạng giữa nhìn trọn sân khấu tốt hơn hàng quá gần.",
          "Đến sớm khoảng 30 phút để dạo công viên và vào chỗ thoải mái.",
          "Show có thể nghỉ một số ngày hoặc khi thời tiết xấu — chúng tôi kiểm tra lịch diễn khi đặt.",
          "Mang áo mỏng chống muỗi và gió sông."],
    btn="Đặt vé Ký Ức Hội An"),
    ko=dict(name="호이안 메모리즈 쇼 (Ký Ức Hội An)", where="호이안 임프레션 테마파크 · 껌남 섬",
    desc="수백 명의 배우가 출연해 호이안 무역항 400년 역사를 호아이강변 야외 무대에서 재현하는 대형 실경 공연.",
    time="약 1시간 (공원 산책 별도)", best="저녁", fit="가족, 커플, 외국인 여행자", move="구시가지 근처",
    tips=["무대 전체가 보이는 중간 좌석이 너무 앞자리보다 좋습니다.",
          "약 30분 일찍 도착해 공원을 둘러보고 여유 있게 착석하세요.",
          "일부 날짜나 악천후에는 공연이 쉬기도 하니 예약 시 일정을 확인해 드립니다.",
          "모기와 강바람을 막을 얇은 겉옷을 챙기세요."],
    btn="호이안 메모리즈 예약")),

  dict(area="ha", vi=dict(
    name="VinWonders Nam Hội An", where="Cách phố cổ ~25 km về phía nam",
    desc="Công viên chủ đề lớn với River Safari (ngắm thú bán hoang dã bằng thuyền), công viên nước, làng văn hóa, show biểu diễn và khu trò chơi.",
    time="Cả ngày", best="Ngày khô ráo, đi từ sáng", fit="Gia đình có trẻ nhỏ", move="Ô tô ~30 phút từ Hội An",
    tips=["Đi River Safari buổi sáng khi thú hoạt động nhiều.",
          "Xem lịch show trong ngày ngay khi vào cổng để sắp xếp.",
          "Mang mũ, kem chống nắng, đồ bơi nếu chơi khu nước.",
          "Kết hợp ngủ một đêm ở Hội An để đỡ di chuyển."],
    btn="Đặt vé VinWonders"),
    ko=dict(name="빈원더스 남호이안", where="구시가지에서 남쪽으로 약 25km",
    desc="보트로 반야생 동물을 보는 리버 사파리, 워터파크, 문화 마을, 공연과 놀이기구가 있는 대형 테마파크.",
    time="하루 종일", best="맑은 날 아침부터", fit="어린 자녀 동반 가족", move="호이안에서 차량 약 30분",
    tips=["동물 활동이 많은 오전에 리버 사파리를 타세요.",
          "입장하자마자 당일 공연 시간표를 확인해 동선을 짜세요.",
          "모자, 선크림, 워터파크용 수영복을 준비하세요.",
          "호이안 1박과 묶으면 이동이 편합니다."],
    btn="빈원더스 예약")),

  dict(area="ha", vi=dict(
    name="Rừng dừa Bảy Mẫu – thuyền thúng", where="Cẩm Thanh · cách phố cổ ~5 km",
    desc="Ngồi thuyền thúng len lỏi rừng dừa nước, xem màn múa thúng, thử câu cua, làm đồ chơi bằng lá dừa — trải nghiệm vui nhộn, rất 'Hội An'.",
    time="1–1,5 tiếng", best="Sáng hoặc chiều mát", fit="Gia đình, nhóm bạn", move="~15 phút từ phố cổ",
    tips=["Thống nhất giá, thời gian và những gì bao gồm trước khi lên thuyền.",
          "Tiền tip cho người chèo và màn múa thúng tùy ý, không bắt buộc.",
          "Mặc áo phao, bọc kỹ điện thoại khi xem múa thúng.",
          "Mùa mưa nước dâng cao có thể tạm dừng; có thể kết hợp tour nấu ăn Cẩm Thanh."],
    btn="Đặt vé thuyền thúng"),
    ko=dict(name="바이마우 코코넛 숲 – 바구니 배", where="껌타인 · 구시가지에서 약 5km",
    desc="바구니 배를 타고 니파야자 숲을 누비며 바구니 배 묘기 공연, 게 낚시, 야자잎 공예를 즐기는 호이안다운 체험.",
    time="1–1.5시간", best="오전 또는 선선한 오후", fit="가족, 친구", move="구시가지에서 약 15분",
    tips=["배에 타기 전에 가격, 시간, 포함 사항을 먼저 정하세요.",
          "사공과 묘기 공연 팁은 선택 사항입니다.",
          "구명조끼를 입고, 묘기 공연 때 휴대폰을 잘 감싸 두세요.",
          "우기에 수위가 높으면 중단될 수 있으며, 껌타인 쿠킹 투어와 묶기 좋습니다."],
    btn="바구니 배 예약")),

  dict(area="ha", vi=dict(
    name="Tour Cù Lao Chàm", where="Cảng Cửa Đại · ca nô ~20–30 phút",
    desc="Tour ca nô ra cụm đảo — Khu dự trữ sinh quyển thế giới: lặn ngắm san hô, tắm biển Bãi Chồng, thăm làng chài và ăn trưa hải sản.",
    time="Cả ngày", best="Mùa biển êm (thường tháng 3–8)", fit="Người thích biển, lặn ngắm san hô", move="Xe đón tại khách sạn",
    tips=["Phụ thuộc thời tiết biển: mùa biển động tàu hay bị hạn chế hoặc tạm dừng — chúng tôi kiểm tra lịch cảng.",
          "Người say sóng uống thuốc trước 30 phút, ăn nhẹ trước khi đi.",
          "Đảo hạn chế túi ni lông — mang bình nước cá nhân.",
          "Mang đồ bơi, kem chống nắng thân thiện san hô, áo khoác chống gió trên ca nô."],
    btn="Hỏi lịch tour Cù Lao Chàm"),
    ko=dict(name="참섬 (Cù Lao Chàm) 투어", where="끄어다이 항 · 스피드보트 약 20–30분",
    desc="세계 생물권 보전지역인 섬으로 스피드보트를 타고 가서 스노클링, 바이쫑 해변 물놀이, 어촌 방문, 해산물 점심을 즐깁니다.",
    time="하루 종일", best="바다가 잔잔한 시기 (보통 3–8월)", fit="바다·스노클링 애호가", move="호텔 픽업",
    tips=["바다 상황에 따라 달라지며, 거친 시기에는 운항이 제한·중단되는 경우가 많아 항구 일정을 확인해 드립니다.",
          "뱃멀미가 있다면 30분 전 약을 먹고 가볍게 식사하세요.",
          "섬은 비닐봉지 사용을 제한하니 개인 물병을 챙기세요.",
          "수영복, 산호 친화 선크림, 보트용 바람막이를 준비하세요."],
    btn="참섬 투어 문의")),

  dict(area="ha", vi=dict(
    name="Thánh địa Mỹ Sơn", where="Duy Xuyên · cách Hội An ~1 giờ",
    desc="Quần thể đền tháp Chăm hơn một nghìn năm tuổi nằm trong thung lũng, được UNESCO công nhận Di sản văn hóa thế giới; vé gồm xe điện vào khu đền tháp và chương trình múa Chăm theo lịch.",
    time="Nửa ngày", best="Sáng sớm; ngày 15 hằng tháng có “Âm vang Mỹ Sơn”", fit="Người yêu lịch sử, kiến trúc", move="Ô tô ~1 giờ từ Hội An",
    tips=["Đi sớm để tránh nắng gắt và mưa chiều, ánh sáng đẹp trên tường gạch.",
          "Mang nước, mũ, giày đi bộ; khu đền tháp rộng, ít bóng mát.",
          "Ghé Bảo tàng Điêu khắc Chăm trước để hiểu câu chuyện.",
          "Có thể kết hợp sáng Mỹ Sơn – chiều phố cổ Hội An."],
    btn="Đặt vé & tour Mỹ Sơn"),
    ko=dict(name="미선 유적지", where="주이쑤옌 · 호이안에서 약 1시간",
    desc="계곡 속 천 년이 넘은 참족 사원군으로 유네스코 세계문화유산입니다. 입장권에는 유적지 전동차와 일정에 따른 참족 무용 공연이 포함됩니다.",
    time="반나절", best="이른 아침, 매달 15일 ‘미선의 울림’ 공연", fit="역사·건축 애호가", move="호이안에서 차량 약 1시간",
    tips=["뜨거운 햇볕과 오후 비를 피하고 벽돌 벽의 빛을 보려면 일찍 가세요.",
          "유적지가 넓고 그늘이 적으니 물, 모자, 걷기 편한 신발을 준비하세요.",
          "참 조각 박물관을 먼저 보면 이야기를 더 잘 이해할 수 있습니다.",
          "오전 미선 – 오후 호이안 구시가지 코스를 추천합니다."],
    btn="미선 입장권·투어")),

  # ---------------- HUẾ ----------------
  dict(area="hue", vi=dict(
    name="Đại Nội & lăng tẩm Huế", where="Kinh thành Huế · cách Đà Nẵng ~100 km",
    desc="Hoàng thành Huế cùng các lăng vua Tự Đức, Khải Định, Minh Mạng — quần thể di tích Cố đô Huế được UNESCO công nhận. Có vé lẻ và vé gộp nhiều điểm.",
    time="1–2 ngày", best="Buổi sáng; mùa xuân, hè ít mưa hơn", fit="Người yêu lịch sử, văn hóa", move="Tàu hỏa hoặc ô tô 2,5–3 giờ",
    tips=["Vé gộp tiết kiệm hơn nếu đi từ 2 điểm trở lên.",
          "Các lăng cách xa nhau và cách Đại Nội — nên thuê xe theo ngày.",
          "Mang ô, giày đế bám: Huế mưa nhiều, sân gạch dễ trơn.",
          "Đại Nội có những thời điểm mở cửa buổi tối — hỏi chúng tôi lịch cụ thể."],
    btn="Đặt vé & xe đi Huế"),
    ko=dict(name="후에 왕궁 & 황릉", where="후에 성 · 다낭에서 약 100km",
    desc="유네스코 세계유산 후에 기념물 단지의 왕궁과 뜨득, 카이딘, 민망 황릉. 개별 티켓과 여러 곳을 묶은 통합 티켓이 있습니다.",
    time="1–2일", best="오전, 비가 적은 봄·여름", fit="역사·문화 애호가", move="기차 또는 차량 2.5–3시간",
    tips=["두 곳 이상 방문하면 통합 티켓이 더 경제적입니다.",
          "황릉들은 왕궁과 서로 멀리 떨어져 있어 하루 차량 대절을 추천합니다.",
          "후에는 비가 잦고 벽돌 마당이 미끄러우니 우산과 미끄럼 방지 신발을 챙기세요.",
          "왕궁 야간 개장 시기가 있으니 일정을 문의하세요."],
    btn="후에 입장권·차량")),

  dict(area="hue", vi=dict(
    name="Thuyền rồng & ca Huế trên sông Hương", where="Sông Hương · Huế",
    desc="Ban ngày đi thuyền rồng ghé chùa Thiên Mụ; buổi tối nghe ca Huế — di sản âm nhạc cung đình — trên thuyền giữa dòng sông, thả đèn hoa đăng.",
    time="1–2 tiếng", best="Buổi tối", fit="Cặp đôi, khách lớn tuổi, người yêu âm nhạc", move="Bến thuyền trung tâm Huế",
    tips=["Ca Huế thường bắt đầu khoảng 19–20 giờ, nên đặt chỗ trước.",
          "Ngồi gần mũi thuyền để nghe rõ; tắt chuông điện thoại khi nghe hát.",
          "Mang áo khoác mỏng vào mùa đông, gió sông lạnh."],
    btn="Đặt vé ca Huế"),
    ko=dict(name="흐엉강 용배 & 까후에 공연", where="흐엉강 · 후에",
    desc="낮에는 용배를 타고 티엔무 사원에 들르고, 저녁에는 배 위에서 궁중 음악 유산 까후에를 들으며 소원등을 띄웁니다.",
    time="1–2시간", best="저녁", fit="커플, 어르신, 음악 애호가", move="후에 시내 선착장",
    tips=["까후에는 보통 19–20시에 시작하니 미리 예약하세요.",
          "뱃머리 쪽에 앉으면 잘 들리며, 공연 중에는 휴대폰을 무음으로 해 주세요.",
          "겨울에는 강바람이 차니 얇은 겉옷을 챙기세요."],
    btn="까후에 예약")),
]

T = dict(
  vi=dict(lbl=dict(time="⏱ Nên dành", best="🌤 Thời điểm đẹp", fit="👥 Phù hợp", move="🚗 Di chuyển"), kn="Kinh nghiệm &amp; lưu ý",
          areas=dict(dn="Đà Nẵng", ha="Hội An – Quảng Nam", hue="Huế")),
  ko=dict(lbl=dict(time="⏱ 소요 시간", best="🌤 추천 시기", fit="👥 추천 대상", move="🚗 이동"), kn="팁 &amp; 유의사항",
          areas=dict(dn="다낭", ha="호이안 – 꽝남", hue="후에")),
)

def cards(lang, area):
    out = ['<div class="ds-tickets">']
    for a in A:
        if a["area"] != area: continue
        d = a[lang]; L = T[lang]
        facts = "".join(f'<li><span>{L["lbl"][k]}</span>{html.escape(d[k])}</li>' for k in ("time", "best", "fit", "move"))
        tips = "".join(f"<li>{html.escape(t)}</li>" for t in d["tips"])
        out.append(f'<div class="ds-ticket"><span class="where">{html.escape(d["where"])}</span><h3>{html.escape(d["name"])}</h3>'
                   f'<p>{html.escape(d["desc"])}</p><ul class="facts">{facts}</ul>'
                   f'<div class="tip"><strong>{L["kn"]}</strong><ul>{tips}</ul></div>'
                   f'<a class="ds-btn" href="{ZALO}" target="_blank" rel="noopener">{html.escape(d["btn"])}</a></div>')
    out.append("</div>")
    return "\n".join(out)

def build(lang):
    src = open(os.path.join(os.path.dirname(__file__), f"khung_{lang}.html"), encoding="utf-8").read()
    for area in ("dn", "ha", "hue"):
        src = src.replace("{{" + area + "}}", cards(lang, area))
    open(os.path.join(os.path.dirname(__file__), f"{lang}.html"), "w", encoding="utf-8").write(src)

if __name__ == "__main__":
    for l in ("vi", "ko"):
        build(l)
    print("ok", len(A), "điểm")
