// Dán cấu hình Firebase của bạn vào đây (Firebase console → Project settings → Your apps → Web app → SDK setup and configuration → Config).
// Khi còn để giá trị "DIEN_..." app sẽ chạy ở chế độ demo (dữ liệu chỉ lưu trên máy đang mở).
export const firebaseConfig = {
  apiKey: "AIzaSyCAPWKp9pA2LheZarLXqCLEnW6VqOltinU",
  // Trên Netlify: đăng nhập Google chạy ngay trên tên miền của app (Netlify chuyển tiếp /__/auth/* về Firebase, xem _redirects)
  // để không lỗi "missing initial state" ở iPhone/Safari, app cài màn hình chính và trình duyệt chặn bộ nhớ chéo tên miền.
  authDomain: /\.netlify\.app$/.test(location.hostname) ? location.hostname : "crm-sale-collection.firebaseapp.com",
  projectId: "crm-sale-collection",
  storageBucket: "crm-sale-collection.firebasestorage.app",
  messagingSenderId: "17651223843",
  appId: "1:17651223843:web:8777ed98c9e8269a195096"
};

// Email chủ hệ thống: luôn có quyền Quản trị, kể cả khi chưa có trong danh sách đội.
// Phải trùng với email trong firestore.rules (hàm isOwner).
export const OWNER_EMAIL = "hiephoangmt@gmail.com";
