// Câu chú thích cảm xúc cho kiểu ảnh quảng cáo (theo loại phòng)
const COPY = {
  bedroom: [
    { icon: '🌿', title: 'Phòng ngủ rộng rãi', line: 'Thoáng sáng và gần gũi thiên nhiên' },
    { icon: '🍃', title: 'Không gian riêng tư', line: 'Thoải mái cho cả gia đình' },
    { icon: '🌙', title: 'Giấc ngủ an yên', line: 'Ấm áp, yên tĩnh mỗi đêm' },
  ],
  living: [{ icon: '☀️', title: 'Ánh sáng tự nhiên', line: 'Lan toả khắp không gian sống' }],
  kitchen: [{ icon: '♡', title: 'Bếp mở hiện đại', line: 'Kết nối yêu thương' }],
  wet: [
    { icon: '🛡', title: 'Tiện nghi đầy đủ', line: 'Sạch sẽ – Hiện đại – Tiện lợi' },
    { icon: '💧', title: 'Phòng tắm thư giãn', line: 'Khô ráo, sáng sủa' },
  ],
  outdoor: [{ icon: '☀️', title: 'Lô gia đón gió', line: 'Thư giãn mỗi sớm mai' }],
  garden: [{ icon: '🌳', title: 'Sân vườn xanh mát', line: 'Đón trọn ánh sáng bình minh' }],
  multi: [{ icon: '✿', title: 'Phòng đa năng', line: 'Làm việc, đọc sách hay phòng khách' }],
};

export function adCaption(name, nth = 1) {
  const n = (name || '').toLowerCase();
  let k = /sân vườn/.test(n) ? 'garden' : /đa năng/.test(n) && !/khách/.test(n) ? 'multi' : null;
  if (!k) {
    if (/tắm|wc|vệ sinh/.test(n)) k = 'wet';
    else if (/lô ?gia|ban công/.test(n)) k = 'outdoor';
    else if (/ngủ/.test(n)) k = 'bedroom';
    else if (/bếp/.test(n) && !/khách/.test(n)) k = 'kitchen';
    else k = 'living';
  }
  const list = COPY[k];
  return list[(nth - 1) % list.length];
}

export const AD_FOOTER = { title: 'Không gian sống lý tưởng', line: 'Cho những khoảnh khắc hạnh phúc' };
