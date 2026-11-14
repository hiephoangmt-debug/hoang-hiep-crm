<?php
/**
 * Mặt bằng chia lô trên bản đồ vệ tinh (dạng vector, bấm từng lô xem diện tích – rộng – sâu).
 * Dữ liệu lô lấy từ file CAD quy hoạch anh Hiệp gửi (Hoa XUan 2019.dwg): ranh lô, mép đường đúng kích thước thật,
 * hướng Bắc theo lưới bản vẽ. File CAD không ghi hệ tọa độ dùng được, nên vị trí trên bản đồ do admin ghim 1 lần
 * (dán tọa độ Google Maps của điểm mốc → Căn theo điểm → Lưu). Khách chỉ thấy khi anh Hiệp bấm "Cho khách xem".
 */

defined( 'ABSPATH' ) || exit;

/** Danh sách sơ đồ theo slug dự án. Dữ liệu lô / đường / nhãn ở file JSON (đơn vị mét, gốc tọa độ là tâm khu). */
function hh_mbbd_plans() {
	return array(
		'euro-village-2' => array(
			'title'   => 'Euro Village 2 – phân khu B2',
			'data'    => 'img/mat-bang-ban-do/euro-village-2-lo.json',
			'image'   => 'img/mat-bang-ban-do/euro-village-2-b2-so-do.jpg',
			'center'  => array( 16.02494, 108.23030 ), // Gợi ý ban đầu (Plus Code 26FJ+X4F, đường Giáng Hương 6) – admin ghim lại cho đúng.
			'anchors' => array(
				array( 'Tâm vòng tròn trong công viên', 86.12, 30.74 ),
			),
		),
	);
}

function hh_mbbd_for( $post_id ) {
	$slug  = (string) get_post_field( 'post_name', $post_id );
	$plans = hh_mbbd_plans();
	return isset( $plans[ $slug ] ) ? array( $slug, $plans[ $slug ] ) : null;
}

add_filter(
	'hh_project_has_map_plan',
	static function ( $has, $post_id ) {
		$f = hh_mbbd_for( $post_id );
		return $has || ( $f && ( current_user_can( 'manage_options' ) || get_option( 'hh_mbbd_duyet_' . $f[0] ) ) );
	},
	10,
	2
);

add_action(
	'hh_project_map_plan',
	static function ( $post_id ) {
		$found = hh_mbbd_for( $post_id );
		if ( ! $found ) {
			return;
		}
		list( $slug, $p ) = $found;
		$admin = current_user_can( 'manage_options' );
		if ( ! $admin && ! get_option( 'hh_mbbd_duyet_' . $slug ) ) {
			return; // Chưa được anh Hiệp duyệt: khách không thấy sơ đồ.
		}
		$saved = get_option( 'hh_mbbd2_' . $slug );
		$cfg   = array(
			'data'    => HH_CRM_URL . $p['data'] . '?v=' . HH_CRM_VERSION,
			'center'  => $p['center'],
			'anchors' => $p['anchors'],
			'saved'   => is_array( $saved ) ? $saved : null,
			'admin'   => $admin,
			'ajax'    => admin_url( 'admin-ajax.php' ),
			'nonce'   => $admin ? wp_create_nonce( 'hh_mbbd_' . $slug ) : '',
			'slug'    => $slug,
		);
		$id    = 'hh-mbbd-' . $slug;
		$duyet = (bool) get_option( 'hh_mbbd_duyet_' . $slug );
		?>
<div class="hh-mbbd" style="margin:28px 0 8px">
<h3 style="margin:0 0 6px;font-size:1.15rem">Mặt bằng chia lô <?php echo esc_html( $p['title'] ); ?></h3>
<p style="font-size:.9rem;color:#6b5b4b;margin:0 0 10px">Bấm vào từng lô để xem <b>diện tích, chiều rộng, chiều sâu</b>. Kéo thanh <b>Độ đậm</b> để so với ảnh vệ tinh hiện trạng.</p>
<div id="<?php echo esc_attr( $id ); ?>" style="height:min(78vh,640px);border-radius:12px;overflow:hidden;background:#dfe9ef"></div>
<div class="hh-mbbd-bar" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-top:8px;font-size:.9rem">
	<label>Độ đậm <input type="range" min="0" max="100" value="85" data-k="op" style="vertical-align:middle"></label>
	<?php if ( $admin ) : ?>
	<span style="flex-basis:100%;color:#8a4b1c"><b>Admin – ghim vị trí 1 lần:</b> mở Google Maps (vệ tinh) → bấm chuột phải đúng <b>tâm vòng tròn trong công viên</b> (chấm xanh ①) → bấm dòng tọa độ để sao chép → dán vào ô → <b>Căn theo điểm</b> → kiểm tra khớp → <b>Lưu vị trí</b>. Có thể kéo chấm đỏ / xoay để chỉnh tinh.</span>
	<label style="flex-basis:100%">① Tâm vòng tròn công viên: <input type="text" data-k="a1" placeholder="VD 16.02494, 108.23030" style="min-width:240px;padding:5px 8px"></label>
	<button type="button" data-k="go" style="background:#c99234;color:#fff;border:0">Căn theo điểm</button>
	<button type="button" data-k="r-1">⟲ 1°</button><button type="button" data-k="r-.2">⟲ 0,2°</button><button type="button" data-k="r.2">⟳ 0,2°</button><button type="button" data-k="r1">⟳ 1°</button>
	<button type="button" data-k="save" style="background:#532516;color:#fff;border:0;border-radius:6px;padding:6px 14px">Lưu vị trí</button>
	<button type="button" data-k="reset">Bỏ vị trí đã lưu</button>
	<button type="button" data-k="pub" data-v="<?php echo $duyet ? '0' : '1'; ?>" style="background:<?php echo $duyet ? '#fff' : '#167a3e'; ?>;color:<?php echo $duyet ? '#167a3e' : '#fff'; ?>"><?php echo $duyet ? 'Đang hiện cho khách – bấm để ẩn' : 'Đang ẩn với khách – bấm để cho khách xem'; ?></button>
	<span data-k="st" style="color:#555"></span>
	<?php endif; ?>
</div>
<p style="font-size:.8rem;color:#6b5b4b;margin:6px 0 0">Ranh lô, kích thước đo từ bản vẽ quy hoạch (tham khảo); diện tích, kích thước chính xác theo hồ sơ từng lô của chủ đầu tư. Ảnh vệ tinh: Esri.</p>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
(function () {
	var C = <?php echo wp_json_encode( $cfg ); ?>;
	var el = document.getElementById(<?php echo wp_json_encode( $id ); ?>);
	if (!window.L || !el) { return; }
	var bar = el.nextElementSibling;
	var st = C.saved ? { lat: +C.saved.lat, lng: +C.saved.lng, rot: +C.saved.rot, sc: +C.saved.sc } : { lat: C.center[0], lng: C.center[1], rot: 0, sc: 1 };
	var map = L.map(el, { scrollWheelZoom: false, maxZoom: 21, zoomSnap: 0.5 }).setView([st.lat, st.lng], 17);
	var sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 21, maxNativeZoom: 19, attribution: 'Ảnh vệ tinh © Esri, Maxar' }).addTo(map);
	var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 21, maxNativeZoom: 19, attribution: '© OpenStreetMap' });
	L.control.layers({ 'Vệ tinh': sat, 'Bản đồ đường': osm }).addTo(map);
	el.addEventListener('click', function () { map.scrollWheelZoom.enable(); }, { once: true });
	// Mét (Đông, Bắc) quanh gốc khu → tọa độ: xoay theo góc lệch, co giãn, cộng vào tâm.
	function m2ll(e, n) {
		var t = st.rot * Math.PI / 180, E = (e * Math.cos(t) + n * Math.sin(t)) * st.sc, N = (-e * Math.sin(t) + n * Math.cos(t)) * st.sc;
		return L.latLng(st.lat + N / 111320, st.lng + E / (111320 * Math.cos(st.lat * Math.PI / 180)));
	}
	var D = null, grp = L.layerGroup().addTo(map), lbl = L.layerGroup().addTo(map), anc = L.layerGroup().addTo(map), op = 0.85;
	var fmt = function (v, d) { return v.toLocaleString('vi-VN', { maximumFractionDigits: d, minimumFractionDigits: d }); };
	function draw() {
		if (!D) { return; }
		grp.clearLayers(); lbl.clearLayers();
		D.roads.forEach(function (r) { L.polyline(r.map(function (p) { return m2ll(p[0], p[1]); }), { color: '#ffffff', weight: 1.2, opacity: Math.min(1, op + .1), interactive: false }).addTo(grp); });
		D.lots.forEach(function (l) {
			var pg = L.polygon(l[4].map(function (p) { return m2ll(p[0], p[1]); }), { color: '#7a4a22', weight: 1, fillColor: '#f6e7cc', fillOpacity: op * .75, opacity: op });
			pg.bindPopup('<b>Lô thuộc block ' + l[0] + '</b><br>Diện tích ≈ <b>' + fmt(l[1], 0) + ' m²</b><br>Rộng (mặt tiền) ≈ <b>' + fmt(l[2], 1) + ' m</b> · Sâu ≈ <b>' + fmt(l[3], 1) + ' m</b><br><small>Đo từ bản vẽ quy hoạch, tham khảo. Liên hệ Hoàng Hiệp 0904 567 009 để nhận thông tin lô.</small>');
			pg.on('mouseover', function () { pg.setStyle({ fillColor: '#f2a65a' }); });
			pg.on('mouseout', function () { pg.setStyle({ fillColor: '#f6e7cc' }); });
			pg.addTo(grp);
		});
		var big = map.getZoom() >= 17.5;
		D.labels.forEach(function (a) {
			L.marker(m2ll(a[1], a[2]), { interactive: false, icon: L.divIcon({ className: 'hh-mbbd-lb', html: '<b>' + a[0] + '</b>' + (big && a[3] ? '<br><small>' + a[3] + '</small>' : ''), iconSize: null }) }).addTo(lbl);
		});
		drawAnchors();
	}
	function drawAnchors() {
		anc.clearLayers();
		if (!C.admin) { return; }
		(C.anchors || []).forEach(function (k, i) { L.marker(m2ll(k[1], k[2]), { interactive: false, icon: L.divIcon({ className: '', html: '<div style="transform:translate(-50%,-50%);width:24px;height:24px;border-radius:50%;background:#1d4ed8;color:#fff;font:700 13px/24px sans-serif;text-align:center;border:2px solid #fff;box-shadow:0 0 5px #000">' + (i + 1) + '</div>', iconSize: null }) }).addTo(anc); });
	}
	fetch(C.data).then(function (r) { return r.json(); }).then(function (j) {
		D = j;
		var b = L.latLngBounds(D.lots.map(function (l) { return m2ll(l[4][0][0], l[4][0][1]); }));
		map.fitBounds(b, { padding: [10, 10] });
		draw();
	});
	map.on('zoomend', draw);
	var css = document.createElement('style');
	css.textContent = '.hh-mbbd-lb{background:rgba(255,255,255,.92);border:2px solid #c99234;border-radius:8px;padding:2px 7px;color:#532516;font:600 12px/1.25 "Be Vietnam Pro",sans-serif;text-align:center;white-space:nowrap;transform:translate(-50%,-50%);width:auto!important;height:auto!important}.hh-mbbd-lb small{color:#6b5040;font-weight:500}.hh-mbbd-bar button{border:1px solid #c99234;background:#fff;border-radius:6px;padding:5px 10px;cursor:pointer}';
	document.head.appendChild(css);
	bar.querySelector('[data-k=op]').addEventListener('input', function () { op = this.value / 100; draw(); });
	if (!C.admin) { return; }
	var msg = bar.querySelector('[data-k=st]');
	function show() { msg.textContent = st.lat.toFixed(6) + ', ' + st.lng.toFixed(6) + ' · xoay ' + st.rot.toFixed(1) + '°'; }
	var pin = L.marker([st.lat, st.lng], { draggable: true, zIndexOffset: 1000, icon: L.divIcon({ className: '', html: '<div style="width:22px;height:22px;border-radius:50%;background:#d33;border:3px solid #fff;box-shadow:0 0 6px #000;transform:translate(-50%,-50%)"></div>', iconSize: null }) }).addTo(map);
	pin.on('dragend', function (ev) { var q = ev.target.getLatLng(); st.lat = q.lat; st.lng = q.lng; draw(); show(); });
	bar.querySelectorAll('button[data-k]').forEach(function (b) {
		b.addEventListener('click', function () {
			var k = b.getAttribute('data-k');
			if (k === 'go') {
				var v = (bar.querySelector('[data-k=a1]').value.match(/-?\d+(?:\.\d+)?/g) || []).map(parseFloat);
				if (v.length < 2) { msg.textContent = 'Chưa đọc được tọa độ.'; return; }
				var K = C.anchors[0];
				st.lat = v[0]; st.lng = v[1];
				var q = m2ll(K[1], K[2]);
				st.lat -= q.lat - v[0]; st.lng -= q.lng - v[1];
				pin.setLatLng([st.lat, st.lng]); map.setView([v[0], v[1]], 17.5); draw(); show();
				return;
			}
			if (k === 'pub' || k === 'save' || k === 'reset') {
				var fd = new FormData();
				fd.append('action', 'hh_mbbd_save'); fd.append('slug', C.slug); fd.append('_wpnonce', C.nonce);
				if (k === 'pub') { fd.append('pub', b.getAttribute('data-v')); }
				else if (k === 'save') { fd.append('lat', st.lat); fd.append('lng', st.lng); fd.append('rot', st.rot); fd.append('sc', st.sc); }
				else { fd.append('reset', '1'); }
				msg.textContent = 'Đang lưu…';
				fetch(C.ajax, { method: 'POST', body: fd, credentials: 'same-origin' }).then(function (r) { return r.json(); }).then(function (j) {
					if (k === 'pub') { location.reload(); return; }
					msg.textContent = j && j.success ? (k === 'save' ? 'Đã lưu vị trí.' : 'Đã bỏ vị trí đã lưu.') : 'Lưu lỗi, thử lại.';
				});
				return;
			}
			st.rot += parseFloat(k.slice(1));
			draw(); show();
		});
	});
	show();
})();
</script>
		<?php
	}
);

add_action(
	'wp_ajax_hh_mbbd_save',
	static function () {
		$slug = sanitize_key( wp_unslash( $_POST['slug'] ?? '' ) );
		if ( ! current_user_can( 'manage_options' ) || ! isset( hh_mbbd_plans()[ $slug ] ) || ! check_ajax_referer( 'hh_mbbd_' . $slug, '_wpnonce', false ) ) {
			wp_send_json_error( null, 403 );
		}
		if ( isset( $_POST['pub'] ) ) {
			update_option( 'hh_mbbd_duyet_' . $slug, '1' === $_POST['pub'] ? 1 : 0, false );
			do_action( 'litespeed_purge_all' );
			wp_send_json_success();
		}
		if ( ! empty( $_POST['reset'] ) ) {
			delete_option( 'hh_mbbd2_' . $slug );
			wp_send_json_success();
		}
		$v = array(
			'lat' => (float) wp_unslash( $_POST['lat'] ?? 0 ),
			'lng' => (float) wp_unslash( $_POST['lng'] ?? 0 ),
			'rot' => (float) wp_unslash( $_POST['rot'] ?? 0 ),
			'sc'  => 1.0,
		);
		if ( abs( $v['lat'] - 16 ) > 1 || abs( $v['lng'] - 108.2 ) > 1 ) {
			wp_send_json_error( null, 400 );
		}
		update_option( 'hh_mbbd2_' . $slug, $v, false );
		do_action( 'litespeed_purge_all' );
		wp_send_json_success();
	}
);
