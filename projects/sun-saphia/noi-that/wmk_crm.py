import sys
from PIL import Image, ImageDraw, ImageFont
src,dst,txt=sys.argv[1],sys.argv[2],sys.argv[3]
im=Image.open(src).convert('RGBA'); W,H=im.size
ov=Image.new('RGBA',(W,H),(0,0,0,0)); d=ImageDraw.Draw(ov)
f2=ImageFont.truetype('/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',22)
d.rectangle([0,H-40,W,H],fill=(10,37,64,230)); d.text((16,H-33),txt,font=f2,fill=(255,255,255,255))
Image.alpha_composite(im,ov).convert('RGB').save(dst,'WEBP',quality=86,method=6)
