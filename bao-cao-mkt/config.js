/* Cấu hình trang Báo cáo Marketing.
 * googleClientId: OAuth Client ID (loại "Web application") tạo trong Google Cloud Console,
 *   thêm https://crm-sale-danang.netlify.app vào "Authorized JavaScript origins". Xem README.md.
 * presets: mỗi dự án một bộ link Drive; chọn ở đầu trang. */
window.BAO_CAO_MKT_CONFIG = {
  googleClientId: "",
  defaultTemplate: "https://drive.google.com/file/d/10S0gG5T_o1WOqqkvUiFdwdhauqoa9mA6/view",
  presets: [
    {
      name: "Casa",
      data: "https://docs.google.com/spreadsheets/d/1R_mmNKG_XA6qZrKmzuEAO79OA1Z-xe8jdg63ItufgnU/edit",
      folders: [
        "https://drive.google.com/drive/folders/190Itz7iAOW1KIJtof5_rZ0kB00z9Scbb",
        "https://drive.google.com/drive/folders/15g6CbWkjShZfhJig8BFBVPgbF2QxEuNP",
      ],
      campaign: "CASAMIA BALANCA HOI AN-TATI INVEST ĐỢT 1",
      period: "15/09 - 27/09/2026",
      outName: "bao_cao_casa",
    },
    {
      name: "Sun",
      data: "", // TODO: link Google Sheet số liệu của Sun
      folders: [
        "https://drive.google.com/drive/folders/17BmNADr3i2DZPHrBMDod9283qeoJ9MkV",
        "https://drive.google.com/drive/folders/151ewIIZzUWCFOx3eDDsKtwg7QCg22Oi6",
      ],
      campaign: "",
      period: "",
      outName: "bao_cao_sun",
    },
    { name: "Khác (nhập link)", folders: [] },
  ],
};
