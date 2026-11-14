<?php
/**
 * Mặt bằng trên bản đồ vệ tinh: sơ đồ phân khu vẽ lại đúng tỷ lệ (mét/pixel đo từ chiều dài đường ghi trên tổng mặt bằng),
 * đặt chồng lên ảnh vệ tinh. Tỷ lệ và hướng Bắc đã khóa theo bản vẽ; admin chỉ cần kéo cho khớp vị trí một lần rồi bấm Lưu.
 * Khách chỉ thấy bản đồ sau khi admin đã căn và lưu – trước đó chỉ hiện ảnh sơ đồ (tránh đặt lệch chỗ).
 */

defined( 'ABSPATH' ) || exit;

/** Danh sách sơ đồ theo slug dự án. Nhãn: [tên, dòng phụ, x, y] với x, y là tỷ lệ 0–1 trên ảnh. */
function hh_mbbd_plans() {
	$w = 2949;
	$h = 2478;
	$l = static function ( $a, $b, $x, $y ) use ( $w, $h ) {
		return array( $a, $b, round( $x / $w, 4 ), round( $y / $h, 4 ) );
	};
	return array(
		'euro-village-2' => array(
			'title'   => 'Euro Village 2 – phân khu B2',
			'overlay' => 'img/mat-bang-ban-do/euro-village-2-b2-overlay.png',
			'image'   => 'img/mat-bang-ban-do/euro-village-2-b2-so-do.jpg',
			'ratio'   => $h / $w,
			'width_m' => $w * 0.88 / 3, // ≈ 865 m: đo theo Đường số 6 (204 m), số 7 (164 m), số 8 (204 m), số 4 (471 m).
			'bearing' => 35.7,          // Hướng phía trên ảnh so với Bắc thật (theo mũi tên Bắc trên bản vẽ).
			'center'  => array( 16.02494, 108.23030 ), // Plus Code 26FJ+X4F (đường Giáng Hương 6, trong Euro Village 2) – admin kéo cho khớp rồi Lưu.
			'labels'  => array(
				$l( 'B2-8', '104 lô · 39.083 m²', 1620, 726 ),
				$l( 'B2-11', '61 lô · 20.403 m²', 1467, 1144 ),
				$l( 'B2-15', '51 lô · 15.766 m²', 2119, 1112 ),
				$l( 'B2-16', '54 lô · 16.329 m²', 2329, 1285 ),
				$l( 'B2-13', '27 lô · 8.343 m²', 1738, 1548 ),
				$l( 'B2-12', '33 lô · 10.228 m²', 1775, 1794 ),
				$l( 'B2-12-1', '9 lô · 4.259 m²', 1113, 1900 ),
				$l( 'B2-9', '9 lô · 5.101 m²', 828, 1986 ),
				$l( 'B2-21', '10 lô · 3.250 m²', 2329, 465 ),
				$l( 'B2-18', '13 lô · 4.456 m²', 2341, 652 ),
				$l( 'B2-17', '', 2476, 1494 ),
				$l( 'Công viên', '', 1750, 1149 ),
				$l( 'Trường mẫu giáo', '', 2058, 694 ),
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
		return $has || null !== hh_mbbd_for( $post_id );
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
		$saved = get_option( 'hh_mbbd_' . $slug );
		if ( is_array( $saved ) && abs( (float) $saved['lat'] - 16.0176 ) < 0.0005 && abs( (float) $saved['lng'] - 108.2282 ) < 0.0005 ) {
			$saved = false; // Vị trí lưu nhầm theo điểm gợi ý cũ (sai chỗ) – bỏ, dùng tọa độ mới.
		}
		$admin = current_user_can( 'manage_options' );
		$img   = HH_CRM_URL . $p['image'] . '?v=' . HH_CRM_VERSION;
		echo '<div class="hh-mbbd" style="margin:28px 0 8px">';
		echo '<h3 style="margin:0 0 6px;font-size:1.15rem">Sơ đồ ' . esc_html( $p['title'] ) . ' – vẽ lại đúng tỷ lệ</h3>';
		if ( ! is_array( $saved ) && ! $admin ) {
			echo '<a href="' . esc_url( $img ) . '" target="_blank" rel="noopener"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( 'Sơ đồ ' . $p['title'] ) . '" loading="lazy" decoding="async" style="width:100%;height:auto;border-radius:12px"></a>';
			echo '<p style="font-size:.85rem;color:#6b5b4b;margin:6px 0 0">Sơ đồ minh họa vẽ lại theo tổng mặt bằng, không thay thế bản vẽ quy hoạch pháp lý.</p></div>';
			return;
		}
		$cfg = array(
			'overlay' => HH_CRM_URL . $p['overlay'] . '?v=' . HH_CRM_VERSION,
			'ratio'   => $p['ratio'],
			'width'   => $p['width_m'],
			'bearing' => $p['bearing'],
			'center'  => $p['center'],
			'labels'  => $p['labels'],
			'saved'   => is_array( $saved ) ? $saved : null,
			'admin'   => $admin,
			'ajax'    => admin_url( 'admin-ajax.php' ),
			'nonce'   => $admin ? wp_create_nonce( 'hh_mbbd_' . $slug ) : '',
			'slug'    => $slug,
		);
		$id = 'hh-mbbd-' . $slug;
		?>
<p style="font-size:.9rem;color:#6b5b4b;margin:0 0 10px">Sơ đồ phân khu đặt trên ảnh vệ tinh thật. Kéo thanh <b>Độ đậm</b> để so với hiện trạng; bấm tên block xem số lô, diện tích. <a href="<?php echo esc_url( $img ); ?>" target="_blank" rel="noopener">Xem ảnh sơ đồ</a>.</p>
<div id="<?php echo esc_attr( $id ); ?>" style="height:min(78vh,620px);border-radius:12px;overflow:hidden;background:#dfe9ef"></div>
<div class="hh-mbbd-bar" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-top:8px;font-size:.9rem">
	<label>Độ đậm <input type="range" min="0" max="100" value="80" data-k="op" style="vertical-align:middle"></label>
	<?php if ( $admin ) : ?>
	<span style="flex-basis:100%;color:#8a4b1c"><b>Admin:</b> kéo chấm đỏ để dời sơ đồ, xoay / co giãn cho khớp đường trên ảnh vệ tinh rồi bấm Lưu. Khách chỉ thấy bản đồ sau khi Lưu.</span>
	<button type="button" data-k="r-1">⟲ 1°</button><button type="button" data-k="r-.2">⟲ 0,2°</button><button type="button" data-k="r.2">⟳ 0,2°</button><button type="button" data-k="r1">⟳ 1°</button>
	<button type="button" data-k="s-1">− 1%</button><button type="button" data-k="s1">+ 1%</button>
	<input type="text" data-k="ll" placeholder="Dán tọa độ Google Maps, VD 16.0249, 108.2303" style="min-width:260px;padding:5px 8px"><button type="button" data-k="go">Dời tâm tới</button>
	<button type="button" data-k="save" style="background:#532516;color:#fff;border:0;border-radius:6px;padding:6px 14px">Lưu vị trí</button>
	<button type="button" data-k="reset">Bỏ vị trí đã lưu</button>
	<span data-k="st" style="color:#555"></span>
	<?php endif; ?>
</div>
<p style="font-size:.8rem;color:#6b5b4b;margin:6px 0 0">Sơ đồ minh họa vẽ lại theo tổng mặt bằng, không thay thế bản vẽ quy hoạch pháp lý. Ảnh vệ tinh: Esri.</p>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
(function () {
	var C = <?php echo wp_json_encode( $cfg ); ?>;
	var el = document.getElementById(<?php echo wp_json_encode( $id ); ?>);
	if (!window.L || !el) { return; }
	var bar = el.nextElementSibling;
	var st = C.saved ? { lat: +C.saved.lat, lng: +C.saved.lng, rot: +C.saved.rot, sc: +C.saved.sc } : { lat: C.center[0], lng: C.center[1], rot: C.bearing, sc: 1 };
	var map = L.map(el, { zoomAnimation: false, scrollWheelZoom: false, maxZoom: 20, zoomSnap: 0.5 }).setView([st.lat, st.lng], 16);
	var sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 20, maxNativeZoom: 19, attribution: 'Ảnh vệ tinh © Esri, Maxar' }).addTo(map);
	var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 20, maxNativeZoom: 19, attribution: '© OpenStreetMap' });
	L.control.layers({ 'Vệ tinh': sat, 'Bản đồ đường': osm }).addTo(map);
	el.addEventListener('click', function () { map.scrollWheelZoom.enable(); }, { once: true });

	// Ảnh pixel (fx, fy theo tỷ lệ 0–1) → tọa độ: dời theo mét, xoay theo hướng, đổi mét sang độ quanh tâm.
	function ll(fx, fy) {
		var w = C.width * st.sc, h = w * C.ratio, dx = (fx - .5) * w, dy = (.5 - fy) * h, t = st.rot * Math.PI / 180;
		var e = dx * Math.cos(t) + dy * Math.sin(t), n = -dx * Math.sin(t) + dy * Math.cos(t);
		return L.latLng(st.lat + n / 111320, st.lng + e / (111320 * Math.cos(st.lat * Math.PI / 180)));
	}
	var img = L.DomUtil.create('img');
	img.src = C.overlay;
	img.style.cssText = 'position:absolute;left:0;top:0;transform-origin:0 0;pointer-events:none;max-width:none;opacity:.8';
	map.getPanes().overlayPane.appendChild(img);
	var labels = L.layerGroup().addTo(map);
	function place() {
		if (!img.naturalWidth) { return; }
		var W = img.naturalWidth, H = img.naturalHeight;
		img.style.width = W + 'px'; img.style.height = H + 'px';
		var p0 = map.latLngToLayerPoint(ll(0, 0)), p1 = map.latLngToLayerPoint(ll(1, 0)), p2 = map.latLngToLayerPoint(ll(0, 1));
		img.style.transform = 'matrix(' + [(p1.x - p0.x) / W, (p1.y - p0.y) / W, (p2.x - p0.x) / H, (p2.y - p0.y) / H, p0.x, p0.y].join(',') + ')';
	}
	function drawLabels() {
		labels.clearLayers();
		var big = map.getZoom() >= 17;
		C.labels.forEach(function (a) {
			var html = '<b>' + a[0] + '</b>' + (a[1] && big ? '<br><small>' + a[1] + '</small>' : '');
			var mk = L.marker(ll(a[2], a[3]), { interactive: !!a[1], icon: L.divIcon({ className: 'hh-mbbd-lb', html: html, iconSize: null }) });
			if (a[1]) { mk.bindPopup('<b>Block ' + a[0] + '</b><br>' + a[1] + '<br><small>Theo tổng mặt bằng, tham khảo.</small>'); }
			mk.addTo(labels);
		});
	}
	img.onload = function () { place(); };
	map.on('zoomend viewreset', function () { place(); drawLabels(); });
	map.fitBounds(L.latLngBounds([ll(0, 0), ll(1, 0), ll(0, 1), ll(1, 1)]), { padding: [10, 10] });
	place(); drawLabels();
	var css = document.createElement('style');
	css.textContent = '.hh-mbbd-lb{background:rgba(255,255,255,.92);border:2px solid #c99234;border-radius:8px;padding:2px 7px;color:#532516;font:600 12px/1.25 "Be Vietnam Pro",sans-serif;text-align:center;white-space:nowrap;transform:translate(-50%,-50%);width:auto!important;height:auto!important}.hh-mbbd-lb small{color:#6b5040;font-weight:500}.hh-mbbd-bar button{border:1px solid #c99234;background:#fff;border-radius:6px;padding:5px 10px;cursor:pointer}';
	document.head.appendChild(css);
	bar.querySelector('[data-k=op]').addEventListener('input', function () { img.style.opacity = this.value / 100; });
	if (!C.admin) { return; }
	var msg = bar.querySelector('[data-k=st]');
	function show() { msg.textContent = st.lat.toFixed(6) + ', ' + st.lng.toFixed(6) + ' · xoay ' + st.rot.toFixed(1) + '° · tỷ lệ ' + Math.round(st.sc * 100) + '%'; }
	var pin = L.marker([st.lat, st.lng], { draggable: true, zIndexOffset: 1000, icon: L.divIcon({ className: '', html: '<div style="width:22px;height:22px;border-radius:50%;background:#d33;border:3px solid #fff;box-shadow:0 0 6px #000;transform:translate(-50%,-50%)"></div>', iconSize: null }) }).addTo(map);
	pin.on('drag', function (ev) { var p = ev.target.getLatLng(); st.lat = p.lat; st.lng = p.lng; place(); show(); });
	pin.on('dragend', function () { drawLabels(); });
	bar.querySelectorAll('button[data-k]').forEach(function (b) {
		b.addEventListener('click', function () {
			var k = b.getAttribute('data-k');
			if (k === 'go') {
				var v = (bar.querySelector('[data-k=ll]').value.match(/-?\d+(?:\.\d+)?/g) || []).map(parseFloat);
				if (v.length < 2) { msg.textContent = 'Chưa đọc được tọa độ.'; return; }
				st.lat = v[0]; st.lng = v[1]; pin.setLatLng([st.lat, st.lng]); map.setView([st.lat, st.lng]); place(); drawLabels(); show(); return;
			}
			if (k !== 'save' && k !== 'reset') {
				if (k.charAt(0) === 'r') { st.rot += parseFloat(k.slice(1)); } else { st.sc *= 1 + parseFloat(k.slice(1)) / 100; }
			} else {
				var fd = new FormData();
				fd.append('action', 'hh_mbbd_save'); fd.append('slug', C.slug); fd.append('_wpnonce', C.nonce);
				if (k === 'save') { fd.append('lat', st.lat); fd.append('lng', st.lng); fd.append('rot', st.rot); fd.append('sc', st.sc); }
				else { fd.append('reset', '1'); }
				msg.textContent = 'Đang lưu…';
				fetch(C.ajax, { method: 'POST', body: fd, credentials: 'same-origin' }).then(function (r) { return r.json(); }).then(function (j) {
					msg.textContent = j && j.success ? (k === 'save' ? 'Đã lưu – khách đã thấy bản đồ này.' : 'Đã bỏ vị trí – khách chỉ thấy ảnh sơ đồ.') : 'Lưu lỗi, thử lại.';
				});
				return;
			}
			place(); drawLabels(); show();
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
		if ( ! empty( $_POST['reset'] ) ) {
			delete_option( 'hh_mbbd_' . $slug );
			wp_send_json_success();
		}
		$v = array(
			'lat' => (float) wp_unslash( $_POST['lat'] ?? 0 ),
			'lng' => (float) wp_unslash( $_POST['lng'] ?? 0 ),
			'rot' => (float) wp_unslash( $_POST['rot'] ?? 0 ),
			'sc'  => (float) wp_unslash( $_POST['sc'] ?? 1 ),
		);
		if ( abs( $v['lat'] - 16 ) > 1 || abs( $v['lng'] - 108.2 ) > 1 || $v['sc'] < 0.5 || $v['sc'] > 2 ) {
			wp_send_json_error( null, 400 );
		}
		update_option( 'hh_mbbd_' . $slug, $v, false );
		do_action( 'litespeed_purge_all' );
		wp_send_json_success();
	}
);
