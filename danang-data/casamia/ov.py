import json, numpy as np, sys
from PIL import Image, ImageDraw
S='/tmp/claude-0/-home-user-hoang-hiep-crm/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/scratchpad/'
M=np.array(json.load(open(S+'casa/affine2.json'))); N_,W_=15.889,108.366
KM=np.diag([107072/57678,110600/60000]); JM=KM@M[:2].T; TM=KM@M[2]; Ji=np.linalg.inv(JM)
d=json.load(open(S+'dn/casamia.json'))
im=Image.open('/root/.claude/uploads/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/ac5bd11a-image.jpg').convert('RGB')
im=Image.blend(im,Image.new('RGB',im.size,(255,255,255)),0.45); dr=ImageDraw.Draw(im)
for l in d['lots']:
    c=np.array([(l['lon']-W_)*107072,(N_-l['lat'])*110600]); u=np.array([np.cos(l['a']),np.sin(l['a'])]); v=np.array([-u[1],u[0]])
    pts=[Ji@(c+u*a*l['d']/2+v*b*l['w']/2-TM) for a,b in((1,1),(1,-1),(-1,-1),(-1,1))]
    dr.polygon([tuple(p) for p in pts],outline=(0,0,200) if l['t']!='PH' else (200,0,0))
im.crop((150,0,2048,1300)).save(S+'ov-all.jpg',quality=85); im.crop((1150,1050,1950,1450)).resize((1600,800)).save(S+'ov-bot.jpg',quality=85)
