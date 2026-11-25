"""Gắn ảnh đại diện cho bài đã đăng: python3 dat_anh.py <ID bài> <link ảnh unsplash | ID media> ["alt"]"""
import json, re, sys, urllib.request
BASE = "https://danangstay.com.vn/wp-json"
pid, src = int(sys.argv[1]), sys.argv[2]
alt = sys.argv[3] if len(sys.argv) > 3 else ""
H = {"User-Agent": "DanangStayBot"}
def post(path, body):
    return json.loads(urllib.request.urlopen(urllib.request.Request(BASE + path, data=json.dumps(body).encode(), method="POST", headers={**H, "Content-Type": "application/json"}), timeout=60).read())
if src.isdigit():
    mid = int(src)
else:
    if not src.startswith("https://images.unsplash.com/"):
        sys.exit("Chỉ nhận ảnh images.unsplash.com")
    data = urllib.request.urlopen(urllib.request.Request(src.split("?")[0] + "?auto=format&fit=crop&w=1600&h=900&q=75", headers=H), timeout=60).read()
    tag = re.sub(r"\W+", "", src.split("photo-")[-1].split("?")[0])[:24]
    mid = json.loads(urllib.request.urlopen(urllib.request.Request(BASE + "/wp/v2/media", data=data, method="POST", headers={**H, "Content-Type": "image/jpeg", "Content-Disposition": f"attachment; filename=bai-{pid}-{tag}.jpg"}), timeout=120).read())["id"]
    if alt:
        post(f"/wp/v2/media/{mid}", {"alt_text": alt, "title": alt})
post(f"/wp/v2/posts/{pid}", {"featured_media": mid})
print(json.dumps({"post": pid, "media": mid}))
