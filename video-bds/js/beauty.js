/* Làm đẹp video bằng WebGL: sáng da, mịn da (giữ chi tiết mắt, tóc, viền áo), làm nét, cân màu. */
(function () {
  'use strict';

  var LEVELS = {
    off: { label: 'Tắt' },
    nhe: { label: 'Nhẹ', smooth: 0.35, lift: 0.04, sharp: 0.35, expo: 1.03, contrast: 1.04, sat: 1.05, warm: 0.01 },
    vua: { label: 'Vừa (khuyên dùng)', smooth: 0.6, lift: 0.07, sharp: 0.55, expo: 1.06, contrast: 1.07, sat: 1.08, warm: 0.015 },
    manh: { label: 'Mạnh', smooth: 0.85, lift: 0.1, sharp: 0.7, expo: 1.09, contrast: 1.09, sat: 1.1, warm: 0.02 }
  };

  var VS = 'attribute vec2 p; varying vec2 uv; void main(){ uv = vec2(p.x*0.5+0.5, 0.5-p.y*0.5); gl_Position = vec4(p,0.,1.); }';
  var FS = [
    'precision mediump float;',
    'varying vec2 uv; uniform sampler2D t; uniform vec2 px;',
    'uniform float uSmooth, uLift, uSharp, uExpo, uContrast, uSat, uWarm;',
    'vec3 S(vec2 o){ return texture2D(t, uv + o * px).rgb; }',
    'void main(){',
    '  vec3 c = S(vec2(0.));',
    // Làm mờ nhỏ (để làm nét) và làm mờ rộng (để làm mịn da)
    '  vec3 b1 = (S(vec2(1.5,0.)) + S(vec2(-1.5,0.)) + S(vec2(0.,1.5)) + S(vec2(0.,-1.5))) * 0.25;',
    '  vec3 b2 = vec3(0.); float n = 0.;',
    '  for (int i = 0; i < 12; i++) { float a = float(i) * 0.5236; vec2 d = vec2(cos(a), sin(a));',
    '    b2 += S(d * 3.5) + S(d * 7.0); n += 2.; }',
    '  b2 /= n;',
    // Vùng da theo màu (YCbCr)
    '  float y = dot(c, vec3(0.299,0.587,0.114));',
    '  float cb = 0.5 + dot(c, vec3(-0.1687,-0.3313,0.5));',
    '  float cr = 0.5 + dot(c, vec3(0.5,-0.4187,-0.0813));',
    '  float skin = smoothstep(0.30,0.36,cb) * (1.-smoothstep(0.50,0.56,cb)) * smoothstep(0.52,0.56,cr) * (1.-smoothstep(0.68,0.72,cr)) * smoothstep(0.15,0.3,y);',
    // Giữ viền rõ (mắt, lông mày, tóc): chỉ làm mịn chỗ khác biệt nhỏ
    '  float edge = 1. - smoothstep(0.04, 0.12, length(c - b2));',
    '  vec3 col = mix(c, b2, uSmooth * skin * edge);',
    '  col += (c - b1) * uSharp * (1. - skin * 0.7);',
    '  col += uLift * skin;',
    '  col *= uExpo;',
    '  col = (col - 0.5) * uContrast + 0.5;',
    '  float g = dot(col, vec3(0.299,0.587,0.114));',
    '  col = mix(vec3(g), col, uSat);',
    '  col.r += uWarm; col.b -= uWarm;',
    '  gl_FragColor = vec4(clamp(col, 0., 1.), 1.);',
    '}'
  ].join('\n');

  function Beauty() {
    this.canvas = document.createElement('canvas');
    var gl = this.gl = this.canvas.getContext('webgl', { premultipliedAlpha: false, preserveDrawingBuffer: true });
    if (!gl) return;
    var sh = function (type, src) { var s = gl.createShader(type); gl.shaderSource(s, src); gl.compileShader(s); return s; };
    var pr = this.pr = gl.createProgram();
    gl.attachShader(pr, sh(gl.VERTEX_SHADER, VS));
    gl.attachShader(pr, sh(gl.FRAGMENT_SHADER, FS));
    gl.linkProgram(pr);
    if (!gl.getProgramParameter(pr, gl.LINK_STATUS)) { this.gl = null; return; }
    gl.useProgram(pr);
    var buf = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, buf);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, 1, 1]), gl.STATIC_DRAW);
    var loc = gl.getAttribLocation(pr, 'p');
    gl.enableVertexAttribArray(loc);
    gl.vertexAttribPointer(loc, 2, gl.FLOAT, false, 0, 0);
    this.tex = gl.createTexture();
    gl.bindTexture(gl.TEXTURE_2D, this.tex);
    [gl.TEXTURE_WRAP_S, gl.TEXTURE_WRAP_T].forEach(function (k) { gl.texParameteri(gl.TEXTURE_2D, k, gl.CLAMP_TO_EDGE); });
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
    this.u = {};
    ['px', 'uSmooth', 'uLift', 'uSharp', 'uExpo', 'uContrast', 'uSat', 'uWarm'].forEach(function (k) { this.u[k] = gl.getUniformLocation(pr, k); }, this);
  }

  /** Trả về canvas đã làm đẹp từ khung hình video hiện tại (hoặc chính video nếu không hỗ trợ). */
  Beauty.prototype.process = function (video, level) {
    var L = LEVELS[level];
    var gl = this.gl;
    if (!gl || !L || !L.smooth || !video.videoWidth) return video;
    var w = video.videoWidth, h = video.videoHeight;
    var k = Math.min(1, 1280 / Math.max(w, h)); // giới hạn kích thước cho nhẹ máy
    w = Math.round(w * k); h = Math.round(h * k);
    if (this.canvas.width !== w || this.canvas.height !== h) { this.canvas.width = w; this.canvas.height = h; gl.viewport(0, 0, w, h); }
    try {
      gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGB, gl.RGB, gl.UNSIGNED_BYTE, video);
    } catch (e) { return video; }
    var u = this.u;
    gl.uniform2f(u.px, 1 / w, 1 / h);
    gl.uniform1f(u.uSmooth, L.smooth); gl.uniform1f(u.uLift, L.lift); gl.uniform1f(u.uSharp, L.sharp);
    gl.uniform1f(u.uExpo, L.expo); gl.uniform1f(u.uContrast, L.contrast); gl.uniform1f(u.uSat, L.sat); gl.uniform1f(u.uWarm, L.warm);
    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
    return this.canvas;
  };

  var shared = null;
  window.BdsBeauty = {
    LEVELS: LEVELS,
    get: function () { if (!shared) shared = new Beauty(); return shared; }
  };
})();
