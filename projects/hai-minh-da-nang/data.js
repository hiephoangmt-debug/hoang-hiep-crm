// Thông tin dự án theo nguồn công khai; danh sách căn và khách hàng bên dưới vẫn là dữ liệu MẪU.
const UNIT_STATUSES = ['Trống', 'Đang giữ chỗ', 'Đã cho thuê', 'Bảo trì'];
const UNIT_TYPES = ['Studio', '1 phòng ngủ', '2 phòng ngủ'];
const STAGES = ['Mới', 'Đã liên hệ', 'Xem căn', 'Đàm phán', 'Đặt cọc', 'Ký hợp đồng', 'Thất bại'];
const SOURCES = ['Facebook', 'Zalo', 'Landing page', 'Giới thiệu', 'Booking/Airbnb', 'Khác'];

const SAMPLE_DATA = {
  project: {
    name: 'Khu căn hộ du lịch, thương mại dịch vụ Hải Minh',
    address: 'Lô A2-1 & A2-2, trục Võ Nguyên Giáp – Trường Sa, P. Ngũ Hành Sơn, Đà Nẵng',
    floors: 30,
    totalUnits: 400,
    amenities: 'Condotel ~400 căn, khối thương mại dịch vụ; cao ~117m; sàn XD >45.000 m²; đối diện Silver Shores',
    hotline: '0904567009',
    manager: 'Hoàng Hiệp',
    notes: 'CĐT: Công ty TNHH Quản lý và Dịch vụ Hạ tầng Kỹ thuật Miền Trung. Đang thi công.',
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
