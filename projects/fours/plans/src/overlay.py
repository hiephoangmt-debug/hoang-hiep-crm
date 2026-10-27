import json,sys
from PIL import Image,ImageDraw,ImageFont
d=json.load(open(sys.argv[1])); im=Image.open('/root/.claude/uploads/04904dc5-f0d4-5f74-b258-32836a553812/'+d['img']).convert('RGB')
im=Image.blend(im,Image.new('RGB',im.size,'white'),.45); g=ImageDraw.Draw(im)
try: f=ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',22)
except: f=None
g.line([tuple(p) for p in d['footPx']]+[tuple(d['footPx'][0])],fill=(220,0,0),width=5)
for G in d['gardensPx']: g.line([tuple(p) for p in G]+[tuple(G[0])],fill=(0,160,0),width=4)
for u in d['units']:
    P=[tuple(p) for p in u['polyPx']]; g.line(P+[P[0]],fill=(0,60,200),width=3)
    cx=sum(p[0] for p in P)/len(P); cy=sum(p[1] for p in P)/len(P); g.text((cx-20,cy-12),u['code'],fill=(0,0,0),font=f)
im.thumbnail((1400,1000)); im.save(sys.argv[2])
