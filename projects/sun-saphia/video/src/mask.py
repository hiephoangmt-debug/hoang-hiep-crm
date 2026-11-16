import numpy as np
from PIL import Image, ImageDraw
im=np.asarray(Image.open('up/tower.jpg').convert('RGB'),np.float32)/255
r,g,b=im[...,0],im[...,1],im[...,2]
blue=(b-r>.18)&(b>.45)
poly=[(489,1700),(489,640),(505,590),(540,548),(600,540),(632,555),(632,505),(660,480),(720,420),(790,330),(800,280),(820,220),(860,170),(900,146),(940,143),(965,175),(980,195),(1150,305),(1170,345),(1200,360),(1224,385),(1226,420),(1205,440),(1203,1700)]
pm=Image.new('L',(1493,2000),0); ImageDraw.Draw(pm).polygon(poly,fill=255); pm=np.asarray(pm)>0
sky=~pm
for it in range(30):
    d=sky.copy(); d[1:]|=sky[:-1]; d[:-1]|=sky[1:]; d[:,1:]|=sky[:,:-1]; d[:,:-1]|=sky[:,1:]
    sky=sky|(d&blue)
m=~sky
np.save('t/tmask.npy',m)
vis=(im*255).astype(np.uint8).copy(); vis[~m]=(vis[~m]*.25+np.array([255,0,0])*.75).astype(np.uint8)
Image.fromarray(vis).crop((420,100,1300,800)).save('t/tvis.png')
Image.fromarray(vis).crop((420,1000,1300,1700)).save('t/tvis2.png')
