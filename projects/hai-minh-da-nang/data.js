// Thông tin dự án theo nguồn công khai; danh sách căn và khách hàng bên dưới vẫn là dữ liệu MẪU.
const UNIT_STATUSES = ['Trống', 'Đang giữ chỗ', 'Đã cho thuê', 'Bảo trì'];
const UNIT_TYPES = ['Studio', '1 phòng ngủ', '2 phòng ngủ'];
const STAGES = ['Mới', 'Đã liên hệ', 'Xem căn', 'Đàm phán', 'Đặt cọc', 'Ký hợp đồng', 'Thất bại'];
const SOURCES = ['Facebook', 'Zalo', 'Landing page', 'Giới thiệu', 'Booking/Airbnb', 'Khác'];

const SAMPLE_DATA = {
  project: {
    name: 'Sun Saphia Residence',
    address: 'Góc Nguyễn Đức Thuận – Trường Sa (trục Võ Nguyên Giáp – Trường Sa), khu Saphia, P. Ngũ Hành Sơn, Đà Nẵng',
    floors: 30,
    totalUnits: 782,
    hotline: '0904567009',
    link4d: 'https://www.sun-saphia-residence.com/#ss4d',
    amenities: 'Khu đất 3.720,1 m²; 1 tòa 30 tầng ~114 m; 2 tầng hầm; 782 căn (Studio 30–31 m², 1PN+1 50–51 m², 2PN 60–70 m²). Đối diện là dải đất resort ven biển; công viên biển Trường Sa (quy hoạch) cuối đường Minh Mạng; gần bãi tắm Sơn Thủy.',
    manager: 'Hoàng Hiệp',
    notes: 'Tên pháp lý: Khu căn hộ du lịch, thương mại dịch vụ Hải Minh. Dự kiến bàn giao 11/2028 (theo tài liệu giới thiệu, có thể thay đổi).',
  },
  units: [
    { id: 'u1', code: 'HM-201', floor: 2, type: 'Studio', area: 30, price: 6000000, status: 'Đã cho thuê' },
    { id: 'u2', code: 'HM-202', floor: 2, type: 'Studio', area: 32, price: 6500000, status: 'Trống' },
    { id: 'u3', code: 'HM-301', floor: 3, type: '1 phòng ngủ', area: 40, price: 8000000, status: 'Đang giữ chỗ' },
    { id: 'u4', code: 'HM-302', floor: 3, type: '1 phòng ngủ', area: 42, price: 8500000, status: 'Trống' },
    { id: 'u5', code: 'HM-501', floor: 5, type: '2 phòng ngủ', area: 60, price: 12000000, status: 'Trống' },
  ],
  customers: [
    { id: 'c1', name: 'Khách mẫu A', phone: '0900000001', source: 'Facebook', unit: 'HM-202', stage: 'Xem căn', note: 'Thuê dài hạn 12 tháng' },
    { id: 'c2', name: 'Khách mẫu B', phone: '0900000002', source: 'Zalo', unit: 'HM-301', stage: 'Đặt cọc', note: '' },
    { id: 'c3', name: 'Khách mẫu C', phone: '0900000003', source: 'Landing page', unit: '', stage: 'Mới', note: 'Hỏi giá căn 2PN' },
  ],
};
