// Liệt kê mọi tiếng tiếng Việt có thể gặp ở lớp 1 (âm đầu × vần × dấu, theo đúng luật chính tả),
// in ra "khoá<TAB>tiếng" để tạo file âm thanh chuẩn. Khoá giống hàm audioKey() trong app.
// Chạy: node be-hoc-lop-1/tools/syllables.mjs > syllables.txt
const VF = { a: "aàáảãạ", "ă": "ăằắẳẵặ", "â": "âầấẩẫậ", e: "eèéẻẽẹ", "ê": "êềếểễệ", i: "iìíỉĩị",
  o: "oòóỏõọ", "ô": "ôồốổỗộ", "ơ": "ơờớởỡợ", u: "uùúủũụ", "ư": "ưừứửữự", y: "yỳýỷỹỵ" };
const isV = c => VF[c] !== undefined;
function toneIndex(ch) { // giống app: kiểu bỏ dấu mới (hoà, thuý)
  const s = ch.join(""), uo = s.indexOf("ươ"); if (uo >= 0) return uo + 1;
  for (let i = 0; i < ch.length; i++) if ("ăâêôơư".includes(ch[i])) return i;
  const vs = []; ch.forEach((c, i) => { if (isV(c)) vs.push(i); });
  if (!vs.length) return -1;
  if (!isV(ch[ch.length - 1])) return vs[vs.length - 1];
  if (vs.length === 1) return vs[0];
  if (vs.length >= 3) return vs[1];
  return ["oa", "oe", "uy"].includes(ch[vs[0]] + ch[vs[1]]) ? vs[1] : vs[0];
}
const applyTone = (w, t) => { if (!t) return w; const ch = [...w], i = toneIndex(ch); if (i < 0) return w; ch[i] = VF[ch[i]][t]; return ch.join(""); };
const key = (base, t) => base.replace(/ă/g, "aw").replace(/â/g, "aa").replace(/ê/g, "ee").replace(/ô/g, "oo")
  .replace(/ơ/g, "ow").replace(/ư/g, "uw").replace(/đ/g, "dd") + t;

const OPEN = "a e ê i o ô ơ u ư y ia ua ưa ai ao au ay âu ây eo êu iu oi ôi ơi ui ưi ưu oa oe uê uy uơ iêu yêu uôi ươi ươu oai oay uây uya".split(" ");
const CLOSED = { // vần + các âm cuối có thể đi sau
  a: "m n ng nh p t c ch", "ă": "m n ng p t c", "â": "m n ng p t c", e: "m n ng p t c", "ê": "m n nh p t ch",
  i: "m n nh p t ch", o: "m n ng p t c", "ô": "m n ng p t c", "ơ": "m n p t", u: "m n ng p t c", "ư": "ng t c n m",
  "iê": "m n ng p t c", "yê": "m n ng p t c", "uô": "m n ng t c", "ươ": "m n ng p t c",
  oa: "m n ng nh p t c ch", "oă": "m n ng t c", oe: "n t", "uâ": "n ng t", "uê": "nh ch", uy: "n nh t ch p", "uyê": "n t"
};
const RHYMES = [...OPEN];
for (const [nu, fs] of Object.entries(CLOSED)) for (const f of fs.split(" ")) RHYMES.push(nu + f);
const ONSETS = ["", "b", "c", "ch", "d", "đ", "g", "gi", "h", "kh", "l", "m", "n", "ng", "nh", "p", "ph", "qu", "r", "s", "t", "th", "tr", "v", "x"];
const STOP = /(p|t|c|ch)$/, FRONT = /^(e|ê|i|iê|y)/, MEDIAL = /^(o[aăe]|u[yêâơ])/;
const out = new Map();
const add = (on, rh) => { // dấu đặt trên vần (để "qu", "gi" không nhận dấu)
  for (let t = 0; t < 6; t++) {
    if (STOP.test(rh) && t !== 2 && t !== 5) continue;
    out.set(key(on + rh, t), on + applyTone(rh, t));
  }
};
for (let on of ONSETS) for (let r of RHYMES) {
  if (on && r.startsWith("yê")) r = "iê" + r.slice(2);           // có âm đầu thì viết iê
  if (!on && r.startsWith("iê")) r = "yê" + r.slice(2);          // không âm đầu thì viết yê
  if (on && /^y/.test(r) && r !== "y") continue;
  if (on === "qu" && /^[uoư]/.test(r)) continue;
  if (MEDIAL.test(r) && ["b", "m", "p", "v", "ph", "qu", "g", "gi"].includes(on)) continue;
  let o = on;
  if (o === "c" && FRONT.test(r)) o = "k";
  if (o === "g" && FRONT.test(r)) o = "gh";
  if (o === "ng" && FRONT.test(r)) o = "ngh";
  if (o === "gi" && r.startsWith("i")) r = r.slice(1) || "i";
  if (o === "gi" && r === "i") { for (let t = 0; t < 6; t++) out.set(key("gi", t), "g" + applyTone("i", t)); continue; }
  add(o, r);
}
for (const [k, s] of out) console.log(k + "\t" + s);
