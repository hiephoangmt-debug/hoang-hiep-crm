// Them anh nen vao comp "SUN SAPHIA - VI TRI" (chay SAU script chinh)
// Dat file nay canh thu muc "anh-nen". File > Scripts > Run Script File...
(function () {
var D = {"layers": [{"name": "ANH 1 - BIEN DA NANG", "file": "hero-bien.jpg", "t0": 0, "t1": 4.241, "an": [[834, 471], [834, 471]], "sc": [204, 228]}, {"name": "ANH 2 - SO DO DA NANG", "file": "so-do-vi-tri.jpg", "t0": 4.241, "t1": 8.427, "an": [[500, 700], [560, 800]], "sc": [138, 190]}, {"name": "ANH 3 - VI TRI VE TINH", "file": "vi-tri-saphia.jpg", "t0": 8.427, "t1": 17.973, "an": [[746, 393], [746, 370]], "sc": [245, 275]}, {"name": "ANH 4 - 3 DUONG XUONG BIEN", "file": "ba-duong-xuong-bien.jpg", "t0": 17.973, "t1": 21.114, "an": [[1066, 392], [1066, 392]], "sc": [245, 262]}, {"name": "ANH 5 - KET NOI", "file": "so-do-vi-tri.jpg", "t0": 21.114, "t1": 29.198, "an": [[566, 820], [500, 700]], "sc": [230, 138]}, {"name": "ANH 6 - TOAN CANH", "file": "cdt-hoang-hon-bien-tren-cao.jpg", "t0": 29.198, "t1": 37.56, "an": [[1200, 670], [1200, 670]], "sc": [144, 158]}], "ringSwitch": 17.973, "p3": [746, 323], "p4": [1066, 304]};
var NAME = "SUN SAPHIA - VI TRI";
var comp = null, i;
if (app.project.activeItem && app.project.activeItem instanceof CompItem && app.project.activeItem.name === NAME) { comp = app.project.activeItem; }
if (!comp) { for (i = app.project.numItems; i >= 1; i--) { var it = app.project.item(i); if (it instanceof CompItem && it.name === NAME && it.numLayers > 5) { comp = it; break; } } }
if (!comp) { alert("Khong tim thay comp " + NAME + ". Hay chay script chinh truoc."); return; }
var dir = new Folder(File($.fileName).parent.fsName + "/anh-nen");
if (!dir.exists) { alert("Khong thay thu muc anh-nen canh file script."); return; }
app.beginUndoGroup("Them anh nen");
var shade = null, map = null;
for (i = 1; i <= comp.numLayers; i++) {
    var ly = comp.layer(i);
    if (ly.name.indexOf("TOI NEN") === 0) { shade = ly; }
    if (ly.name.indexOf("MAP - AP GEOLAYERS") === 0) { map = ly; }
}
var cache = {};
for (i = 0; i < D.layers.length; i++) {
    var d = D.layers[i];
    var ft = cache[d.file];
    if (!ft) {
        var f = new File(dir.fsName + "/" + d.file);
        if (!f.exists) { alert("Thieu anh: " + d.file); continue; }
        ft = app.project.importFile(new ImportOptions(f)); cache[d.file] = ft;
    }
    var L = comp.layers.add(ft);
    L.name = d.name;
    var t0 = Math.max(0, d.t0 - (i > 0 ? 0.3 : 0));
    L.startTime = 0; L.inPoint = t0; L.outPoint = Math.min(comp.duration, d.t1 + 0.05);
    L.transform.position.setValue([comp.width / 2, comp.height / 2]);
    L.transform.anchorPoint.setValueAtTime(t0, d.an[0]); L.transform.anchorPoint.setValueAtTime(d.t1, d.an[1]);
    L.transform.scale.setValueAtTime(t0, [d.sc[0], d.sc[0]]); L.transform.scale.setValueAtTime(d.t1, [d.sc[1], d.sc[1]]);
    if (i > 0) { L.transform.opacity.setValueAtTime(t0, 0); L.transform.opacity.setValueAtTime(t0 + 0.3, 100); }
    if (shade) { L.moveAfter(shade); } else if (map) { L.moveBefore(map); }
}
// vong dinh vi bam theo diem Sun Saphia tren anh
for (i = 1; i <= comp.numLayers; i++) {
    var r = comp.layer(i);
    if (r.name.indexOf("VONG DINH VI") === 0) {
        r.transform.position.expression =
            'var a=thisComp.layer("ANH 3 - VI TRI VE TINH"), b=thisComp.layer("ANH 4 - 3 DUONG XUONG BIEN");' +
            '(time < ' + D.ringSwitch + ') ? a.toComp([' + D.p3 + ']) : b.toComp([' + D.p4 + ']);';
        r.name = "VONG DINH VI";
    }
}
if (shade) { shade.transform.opacity.setValue(20); }
app.endUndoGroup();
alert("Da them 6 anh nen vao comp " + NAME + ".\nBam Space de xem thu.");
})();
