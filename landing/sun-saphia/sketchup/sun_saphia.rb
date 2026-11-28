# encoding: UTF-8
# Sun Saphia Residence – dựng khối toà tháp trong SketchUp
# Nguồn: mặt bằng tầng 3A & 18 "Toà Saphia" (Drive dự án). Kích thước suy từ bản vẽ (~0,075 m / pixel),
# là mô hình MINH HOẠ để dựng tiếp, không phải hồ sơ thiết kế.
#
# Cách chạy (SketchUp 2017 trở lên):
#   Cửa sổ (Window) > Ruby Console > dán dòng:  load 'C:/duong-dan/sun_saphia.rb'
#   (hoặc dán toàn bộ nội dung file này vào Ruby Console rồi Enter)
# Trục: +Y (xanh lá) là phía "HƯỚNG BIỂN" trên mặt bằng. Gốc toạ độ ở giữa mặt bằng tầng.

module SunSaphia
  PX = 0.075; CX = 700; CY = 515
  H0 = 4.5   # tầng 1, 2 (khối đế)
  H  = 3.3   # tầng điển hình
  SLAB = 0.32

  OUTLINE = [[318,305],[468,300],[848,300],[848,180],[1085,180],[1085,300],[1000,300],[1000,425],
             [1082,425],[1082,575],[590,575],[590,850],[318,850]]
  # mã, loại, thông thuỷ, tim tường, x0, y0, x1, y1 (pixel trên bản vẽ)
  UNITS = [
    ["11","2BR",70.21,77.35,318,305,468,400],["12","STU",31,34.58,468,300,520,420],["12A","STU",30,34.58,520,300,572,420],
    ["12B","1BR+",51.11,56.42,572,300,662,420],["15","STU",30,34.58,662,300,714,420],["16","STU",30,34.58,714,300,766,420],
    ["17","1BR+",50.18,56.38,766,300,855,420],["18","2BR",67.91,75.5,848,180,966,300],["19","2BR",67.42,76.36,966,180,1085,300],
    ["10","1BR+",51.19,56.42,318,400,445,485],["09","STU",30,34.58,318,485,445,537],["08","STU",30,34.58,318,537,445,590],
    ["07","STU",31,35.03,318,590,445,645],["06","STU",30,34.13,318,645,445,698],["05","STU",30,34.58,318,698,445,750],
    ["03A","2BR",61.31,68.67,318,750,452,850],["03","2BR",60.81,68.32,452,750,590,850],
    ["01","STU",32.61,37.07,465,640,590,695],["02","STU",30,33.88,465,695,590,750],
    ["28","1BR+",48.62,55.27,575,450,660,575],["27","STU",30,33.88,660,450,713,575],["26","STU",30,33.88,713,450,766,575],
    ["25","STU",30,33.88,766,450,819,575],["24","STU",30,33.88,819,450,871,575],["23","STU",30,33.88,871,450,924,575],
    ["22","STU",30,33.88,924,450,977,575],["21","STU",30.1,33.88,977,450,1029,575],["20","STU",39.69,46.38,1029,425,1082,575]
  ]
  CORES = [[855,300,1000,450],[465,450,575,640]]
  CORRS = [[445,420,1000,450],[445,420,465,770]]
  PODIUM = [[250,160],[1120,160],[1120,620],[640,620],[640,900],[250,900]]
  POOL = [330,190,820,292]
  # 30 tầng, bỏ số 4, 13, 14 như cách đánh mã căn trên mặt bằng (cần đối chiếu CĐT)
  FLOORS = %w[1 2 3 3A 5 6 7 8 9 10 11 12 12A 12B] + (15..30).map(&:to_s)
  COLORS = { "STU" => [240,138,124], "1BR+" => [108,199,232], "2BR" => [243,207,107] }

  def self.m(v) v.to_f.m end
  def self.xy(x, y) [(x - CX) * PX, -(y - CY) * PX] end
  def self.pt(x, y, z) a, b = xy(x, y); Geom::Point3d.new(m(a), m(b), m(z)) end
  def self.floor_z(i) i < 2 ? i * H0 : 2 * H0 + (i - 2) * H end

  def self.mat(model, name, rgb, alpha = 1.0)
    mt = model.materials[name] || model.materials.add(name)
    mt.color = Sketchup::Color.new(*rgb); mt.alpha = alpha; mt
  end

  def self.layer(model, name) model.layers[name] || model.layers.add(name) end

  # mặt phẳng từ đa giác pixel ở cao độ z, đùn lên h (mét)
  def self.prism(ents, poly, z, h, material = nil)
    face = ents.add_face(poly.map { |x, y| pt(x, y, z) })
    face.reverse! if face.normal.z < 0
    face.pushpull(m(h))
    ents.grep(Sketchup::Face).each { |f| f.material = material } if material
    face
  end

  def self.rect(x0, y0, x1, y1, inset = 0)
    d = inset / PX
    [[x0 + d, y0 + d], [x1 - d, y0 + d], [x1 - d, y1 - d], [x0 + d, y1 - d]]
  end

  def self.code(floor, u) "SP" + (floor =~ /\A\d\z/ ? "0#{floor}" : floor) + u[0] end

  def self.build
    model = Sketchup.active_model
    model.start_operation("Dựng Sun Saphia", true)
    root = model.active_entities.add_group; root.name = "Sun Saphia Residence"
    ents = root.entities

    m_slab  = mat(model, "SS Sàn",       [236,230,220])
    m_glass = mat(model, "SS Kính",      [150,195,220], 0.35)
    m_cu    = mat(model, "SS Vây đồng",  [184,116,69])
    m_pod   = mat(model, "SS Khối đế",   [217,207,192])
    m_core  = mat(model, "SS Lõi thang", [138,143,147])
    m_corr  = mat(model, "SS Hành lang", [213,213,210])
    m_pool  = mat(model, "SS Bể bơi",    [55,182,214], 0.85)
    m_unit  = COLORS.map { |k, c| [k, mat(model, "SS Căn #{k}", c, 0.9)] }.to_h

    l_pod  = layer(model, "SS Khối đế")
    l_slab = layer(model, "SS Sàn")
    l_glass= layer(model, "SS Vỏ kính")
    l_fin  = layer(model, "SS Vây đồng")
    l_core = layer(model, "SS Lõi + hành lang")
    l_unit = COLORS.keys.map { |k| [k, layer(model, "SS Căn #{k}")] }.to_h

    # Khối đế 2 tầng + bể bơi
    g = ents.add_group; g.name = "Khối đế (tầng 1 TMDV, tầng 2 tiện ích)"; g.layer = l_pod
    prism(g.entities, PODIUM, 0, 2 * H0 - 0.2, m_pod)
    g = ents.add_group; g.name = "Bể bơi mái đế"; g.layer = l_pod
    prism(g.entities, rect(*POOL), 2 * H0 - 0.2, 0.3, m_pool)

    top = floor_z(FLOORS.size)
    (2...FLOORS.size).each do |i|
      fname = FLOORS[i]; z = floor_z(i)
      fg = ents.add_group; fg.name = "Tầng #{fname}"
      fe = fg.entities
      s = fe.add_group; s.name = "Sàn tầng #{fname}"; s.layer = l_slab
      prism(s.entities, OUTLINE, z, SLAB, m_slab)
      sh = fe.add_group; sh.name = "Vỏ kính tầng #{fname}"; sh.layer = l_glass
      prism(sh.entities, OUTLINE, z + SLAB, H - SLAB, m_glass)
      sh.entities.grep(Sketchup::Face).select { |f| f.normal.z.abs > 0.99 }.each(&:erase!)  # chỉ giữ vách kính
      (CORES).each do |c|
        cg = fe.add_group; cg.name = "Lõi thang"; cg.layer = l_core
        prism(cg.entities, rect(*c), z + SLAB, 2.9, m_core)
      end
      CORRS.each do |c|
        cg = fe.add_group; cg.name = "Hành lang"; cg.layer = l_core
        prism(cg.entities, rect(*c), z + SLAB, 0.05, m_corr)
      end
      UNITS.each do |u|
        ug = fe.add_group
        ug.name = "#{code(fname, u)} · #{u[1]} · TT #{u[2]} m² · TT #{u[3]} m² tim tường"
        ug.layer = l_unit[u[1]]
        prism(ug.entities, rect(u[4], u[5], u[6], u[7], 0.15), z + SLAB, 2.7, m_unit[u[1]])
        { "ma_can" => code(fname, u), "tang" => fname, "loai" => u[1], "thong_thuy_m2" => u[2], "tim_tuong_m2" => u[3] }
          .each { |k, v| ug.set_attribute("sun_saphia", k, v) }
      end
    end

    # Vây đồng đứng dọc mặt tiền (mỗi ~7,8 m)
    fins = ents.add_group; fins.name = "Vây đồng mặt tiền"; fins.layer = l_fin
    OUTLINE.each_with_index do |p, k|
      q = OUTLINE[(k + 1) % OUTLINE.size]
      a, b = xy(*p); c, d = xy(*q)
      len = Math.hypot(c - a, d - b); n = [1, (len / 7.8).round].max
      ux, uy = (c - a) / len, (d - b) / len
      (0..n).each do |j|
        x = a + (c - a) * j / n; y = b + (d - b) * j / n
        hw, hd = 0.14, 0.35
        poly = [[x - ux*hw - uy*hd, y - uy*hw + ux*hd], [x + ux*hw - uy*hd, y + uy*hw + ux*hd],
                [x + ux*hw + uy*hd, y + uy*hw - ux*hd], [x - ux*hw + uy*hd, y - uy*hw - ux*hd]]
        f = fins.entities.add_face(poly.map { |xx, yy| Geom::Point3d.new(m(xx), m(yy), m(2 * H0)) })
        f.reverse! if f.normal.z < 0
        f.pushpull(m(top - 2 * H0))
      end
    end
    fins.entities.grep(Sketchup::Face).each { |f| f.material = m_cu }

    g = ents.add_group; g.name = "Mái"; g.layer = l_fin
    prism(g.entities, OUTLINE, top, 5, m_cu)

    model.commit_operation
    view = model.active_view
    view.zoom_extents
    UI.messagebox("Đã dựng Sun Saphia: #{FLOORS.size} tầng, #{UNITS.size} căn/tầng điển hình.\n" \
                  "Mỗi căn là một Group có tên mã căn; bật/tắt theo Tag 'SS Căn STU / 1BR+ / 2BR'.")
  rescue => e
    model.abort_operation
    UI.messagebox("Lỗi khi dựng: #{e.message}")
    raise
  end
end

SunSaphia.build
