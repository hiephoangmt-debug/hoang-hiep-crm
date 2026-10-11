/* Cấu hình trang Báo cáo Marketing.
 * googleClientId: OAuth Client ID (loại "Web application") tạo trong Google Cloud Console,
 *   thêm https://crm-sale-danang.netlify.app vào "Authorized JavaScript origins". Xem README.md.
 * presets: mỗi dự án một bộ link Drive; chọn ở đầu trang. */
window.BAO_CAO_MKT_CONFIG = {
  googleClientId: "",
  // Link ứng dụng web Apps Script của CRM (đuôi /exec) – dùng cho trang crm.html trên Netlify
  crmUrl: "",
  // Link trang hướng dẫn (trống = trang ?page=huongdan của CRM)
  guideUrl: "",
  // Logo trong file PPTX mẫu (tên file ảnh trong mẫu) – mỗi dự án chọn một logo ở "logo"
  logos: { "TATILAND": "image8.png", "TATI INVEST": "image9.png" },
  // ID tài khoản quảng cáo -> nhân sự (cho tài khoản không ghi tên trong sheet)
  accountStaff: {
    "1091790822198238": "Mỹ Linh",
  },
  defaultTemplate: "https://drive.google.com/file/d/10S0gG5T_o1WOqqkvUiFdwdhauqoa9mA6/view",
  presets: [
    {
      name: "Casa",
      data: "https://docs.google.com/spreadsheets/d/1R_mmNKG_XA6qZrKmzuEAO79OA1Z-xe8jdg63ItufgnU/edit",
      // Thư mục chứng từ chung (Nhân sự/Dự án/Tuần/ảnh); chỉ lấy ảnh nằm trong thư mục tên "Casamia"
      folders: ["https://drive.google.com/drive/folders/146YOZUIiLizOl0waxcqAPw4uzY_jvmzt"],
      projectKey: "Casamia",
      logo: "TATI INVEST",
      campaign: "CASAMIA BALANCA HOI AN-TATI INVEST ĐỢT 1",
      period: "", // trống = theo tuần báo cáo
      outName: "bao_cao_casa",
    },
    {
      name: "Sun",
      data: "https://docs.google.com/spreadsheets/d/1K1nmmwasaN7kRrKUrqoMPSOFoGhawIZMF2OEiYaQ2iU/edit",
      folders: ["https://drive.google.com/drive/folders/146YOZUIiLizOl0waxcqAPw4uzY_jvmzt"],
      projectKey: "Sun",
      logo: "TATILAND",
      campaign: "SUN GROUP ĐÀ NẴNG - TATI INVEST",
      period: "", // trống = theo tuần báo cáo
      outName: "bao_cao_sun",
    },
    { name: "Khác (nhập link)", folders: [] },
  ],
};
