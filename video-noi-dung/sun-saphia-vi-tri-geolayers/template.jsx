// Sun Saphia Residence - Video vi tri (dung san cho GEOlayers 3)
// Cach chay: After Effects > File > Scripts > Run Script File... > chon file nay.
// Dat file nay cung thu muc voi giong-doc.wav va nhac-nen.wav.
(function () {
/*DATA*/
var FONT_BOLD = "Arial-BoldMT";          // doi sang font ban thich, vi du "SVN-Gilroy-Black"
var FONT_ITALIC = "Arial-BoldItalicMT";
var GOLD = [0.914, 0.725, 0.286], NAVY = [0.04, 0.08, 0.14], WHITE = [1, 1, 1], DARK = [0.1, 0.07, 0.02], ORANGE = [1, 0.48, 0.1];
var W = 1080, H = 1920, FPS = 30;

app.beginUndoGroup("Sun Saphia vi tri");
var here = File($.fileName).parent;
var comp = app.project.items.addComp("SUN SAPHIA - VI TRI", W, H, 1, D.total, FPS);
comp.bgColor = NAVY;

function importAudio(name) {
    var f = new File(here.fsName + "/" + name);
    if (!f.exists) { return null; }
    return app.project.importFile(new ImportOptions(f));
}

// ---------- MAP placeholder (bottom) ----------
var map = comp.layers.addSolid([0.06, 0.1, 0.16], "MAP - AP GEOLAYERS VAO DAY", W, H, 1, D.total);
map.comment = "Chon layer nay > mo panel GEOlayers 3 > tao map, dat camera theo cac marker CAM tren timeline";
// darken overlay for text legibility
var shade = comp.layers.addSolid([0, 0, 0], "TOI NEN (chinh opacity neu can)", W, H, 1, D.total);
shade.opacity.setValue(25);

// ---------- helpers ----------
function textLayer(str, size, font, color, justify) {
    var L = comp.layers.addText(str);
    var sp = L.property("Source Text");
    var td = sp.value;
    try { td.resetCharStyle(); } catch (e0) {}
    td.font = font; td.fontSize = size; td.fillColor = color; td.applyFill = true;
    td.applyStroke = false; td.tracking = 0;
    td.justification = justify;
    sp.setValue(td);
    return L;
}
function pop(L, x, y, t0, t1) {
    L.inPoint = Math.max(0, t0); L.outPoint = Math.min(D.total, t1);
    L.transform.position.setValue([x, y]);
    var op = L.transform.opacity, sc = L.transform.scale;
    op.setValueAtTime(t0, 0); op.setValueAtTime(t0 + 0.12, 100);
    op.setValueAtTime(Math.max(t0 + 0.13, t1 - 0.2), 100); op.setValueAtTime(t1, 0);
    sc.setValueAtTime(t0, [70, 70]); sc.setValueAtTime(t0 + 0.2, [106, 106]); sc.setValueAtTime(t0 + 0.32, [100, 100]);
}
function box(textL, color, padX, padY, strokeColor) {
    var S = comp.layers.addShape();
    S.name = textL.name + " [khung]";
    S.property("ADBE Root Vectors Group").addProperty("ADBE Vector Group");
    function V() { return S.property("ADBE Root Vectors Group").property(1).property("ADBE Vectors Group"); }
    V().addProperty("ADBE Vector Shape - Rect");
    if (strokeColor) { V().addProperty("ADBE Vector Graphic - Stroke"); }
    V().addProperty("ADBE Vector Graphic - Fill");
    // re-fetch every property AFTER all addProperty calls (AE invalidates old references)
    V().property("ADBE Vector Shape - Rect").property("ADBE Vector Rect Roundness").setValue(12);
    if (strokeColor) {
        V().property("ADBE Vector Graphic - Stroke").property("ADBE Vector Stroke Color").setValue(strokeColor);
        V().property("ADBE Vector Graphic - Stroke").property("ADBE Vector Stroke Width").setValue(4);
    }
    V().property("ADBE Vector Graphic - Fill").property("ADBE Vector Fill Color").setValue(color);
    var r = V().property("ADBE Vector Shape - Rect");
    var nm = textL.name.replace(/"/g, '\\"');
    r.property("ADBE Vector Rect Size").expression =
        'var r=thisComp.layer("' + nm + '").sourceRectAtTime(time,false);[r.width+' + (2 * padX) + ',r.height+' + (2 * padY) + ']';
    r.property("ADBE Vector Rect Position").expression =
        'var r=thisComp.layer("' + nm + '").sourceRectAtTime(time,false);[r.left+r.width/2,r.top+r.height/2]';
    S.parent = textL;
    S.transform.position.setValue([0, 0]);
    S.transform.anchorPoint.setValue([0, 0]);
    S.transform.opacity.expression = 'thisComp.layer("' + nm + '").transform.opacity';
    S.inPoint = textL.inPoint; S.outPoint = textL.outPoint;
    S.moveAfter(textL);
    return S;
}
function shadow(L, amount) {
    try {
        L.property("ADBE Effect Parade").addProperty("ADBE Drop Shadow");
        var fx = L.property("ADBE Effect Parade").property(1);
        fx.property("ADBE Drop Shadow-0004").setValue(amount); // distance
        fx.property("ADBE Drop Shadow-0005").setValue(18);     // softness
    } catch (e) {}
}

var CJ = ParagraphJustification.CENTER_JUSTIFY, LJ = ParagraphJustification.LEFT_JUSTIFY;
var count = 0;
for (var i = 0; i < D.els.length; i++) {
    var e = D.els[i], L, j = (e.align === "l") ? LJ : CJ;
    count++;
    if (e.kind === "gold") {
        L = textLayer(e.text, e.size || 46, FONT_BOLD, DARK, j);
        L.name = "TAG " + count + " - " + e.text;
        pop(L, e.x, e.y, e.t0, e.t1); box(L, GOLD, 30, 16, null);
    } else if (e.kind === "chip") {
        L = textLayer(e.text, e.size || 40, FONT_BOLD, WHITE, j);
        L.name = "CHIP " + count + " - " + e.text;
        pop(L, e.x, e.y, e.t0, e.t1); box(L, NAVY, 26, 16, GOLD);
    } else if (e.kind === "big") {
        L = textLayer(e.text, e.size || 120, FONT_BOLD, GOLD, j);
        L.name = "SO " + count + " - " + e.text; pop(L, e.x, e.y, e.t0, e.t1); shadow(L, 8);
    } else if (e.kind === "title") {
        L = textLayer(e.text, e.size || 70, FONT_ITALIC, WHITE, j);
        L.name = "TITLE " + count + " - " + e.text; pop(L, e.x, e.y, e.t0, e.t1); shadow(L, 6);
    } else {
        L = textLayer(e.text, e.size || 34, FONT_BOLD, WHITE, j);
        L.name = "TEXT " + count + " - " + e.text; pop(L, e.x, e.y, e.t0, e.t1);
    }
}

// ---------- location ring (center of frame) ----------
var R = comp.layers.addShape(); R.name = "VONG DINH VI (dat khu dat vao giua khung)";
var RV = function () { return R.property("ADBE Root Vectors Group"); };
RV().addProperty("ADBE Vector Group"); RV().addProperty("ADBE Vector Group");
var G1 = function () { return RV().property(1).property("ADBE Vectors Group"); };
var G2 = function () { return RV().property(2).property("ADBE Vectors Group"); };
G1().addProperty("ADBE Vector Shape - Ellipse"); G1().addProperty("ADBE Vector Graphic - Stroke");
G2().addProperty("ADBE Vector Shape - Ellipse"); G2().addProperty("ADBE Vector Graphic - Fill");
G1().property("ADBE Vector Shape - Ellipse").property("ADBE Vector Ellipse Size").setValue([150, 150]);
G1().property("ADBE Vector Graphic - Stroke").property("ADBE Vector Stroke Color").setValue(ORANGE);
G1().property("ADBE Vector Graphic - Stroke").property("ADBE Vector Stroke Width").setValue(10);
G2().property("ADBE Vector Shape - Ellipse").property("ADBE Vector Ellipse Size").setValue([40, 40]);
G2().property("ADBE Vector Graphic - Fill").property("ADBE Vector Fill Color").setValue(ORANGE);
R.transform.position.setValue([W / 2, H / 2]);
R.transform.scale.expression = "var s=100+12*Math.sin((time-inPoint)*6);[s,s]";
R.inPoint = D.ring[0]; R.outPoint = D.ring[1];
R.transform.opacity.setValueAtTime(D.ring[0], 0); R.transform.opacity.setValueAtTime(D.ring[0] + 0.2, 100);
R.transform.opacity.setValueAtTime(D.ring[1] - 0.2, 100); R.transform.opacity.setValueAtTime(D.ring[1], 0);
try { R.property("ADBE Effect Parade").addProperty("ADBE Glo2"); } catch (e) {}

// ---------- source notes ----------
for (i = 0; i < D.src.length; i++) {
    var sL = textLayer(D.src[i][0], 22, FONT_BOLD, [0.8, 0.8, 0.8], LJ);
    sL.name = "NGUON " + (i + 1);
    sL.transform.position.setValue([40, H - 40]);
    sL.transform.opacity.setValue(70);
    sL.inPoint = D.src[i][1]; sL.outPoint = D.src[i][2];
}

// ---------- captions ----------
for (i = 0; i < D.caps.length; i++) {
    var c = D.caps[i];
    var cL = textLayer(c.text, 50, FONT_ITALIC, WHITE, CJ);
    cL.name = "PHU DE " + (i + 1);
    cL.transform.position.setValue([W / 2, 1580]);
    cL.inPoint = c.t0; cL.outPoint = Math.max(c.t1, c.t0 + 0.2);
    var td = cL.property("Source Text").value;
    try { td.applyStroke = true; td.strokeColor = [0, 0, 0]; td.strokeWidth = 6; td.strokeOverFill = false; } catch (e1) {}
    cL.property("Source Text").setValue(td);
}

// ---------- audio ----------
var vo = importAudio("giong-doc.wav");
if (vo) { var voL = comp.layers.add(vo); voL.name = "GIONG DOC"; voL.moveToEnd(); }
var mu = importAudio("nhac-nen.wav");
if (mu) { var muL = comp.layers.add(mu); muL.name = "NHAC NEN (da giam khi co giong)"; muL.moveToEnd(); }
map.moveToEnd(); // keep map at the very bottom of the visual stack

// ---------- camera markers ----------
for (i = 0; i < D.cams.length; i++) {
    try {
        var mv = new MarkerValue(D.cams[i][1]);
        comp.markerProperty.setValueAtTime(D.cams[i][0], mv);
    } catch (e) {
        var mk = map.property("Marker"); mk.setValueAtTime(D.cams[i][0], new MarkerValue(D.cams[i][1]));
    }
}

comp.openInViewer();
app.endUndoGroup();
alert("Xong! Da tao comp \"SUN SAPHIA - VI TRI\" (" + D.total + "s).\n\n1. Chon layer MAP > GEOlayers 3 > tao ban do ve tinh.\n2. Dat camera theo cac marker CAM 1-8 tren timeline.\n3. O CAM 4: dat khu dat Sun Saphia vao giua khung (vong dinh vi).\n" + (vo ? "" : "\nCHU Y: khong tim thay giong-doc.wav canh file script."));
})();
