import subprocess, json
def dec(f):
    import array
    raw = subprocess.run(["ffmpeg","-v","error","-i",f,"-f","s16le","-ac","1","-ar","44100","-"],capture_output=True).stdout
    return array.array("h", raw)
SR=44100
def trim(a, s=None, e=None):
    s = int((s or 0)*SR); e = int(e*SR) if e else len(a); x = a[s:e]
    th=500; i=0
    while i<len(x) and abs(x[i])<th: i+=1
    j=len(x)-1
    while j>i and abs(x[j])<th: j-=1
    return x[max(0,i-800):min(len(x),j+1800)]
c={k:dec(f"c{k:02d}.mp3") for k in range(1,9)}
pieces=[trim(c[i]) for i in range(1,7)]
b7=[0,2.40,4.46,6.92,None]; pieces+= [trim(c[7],b7[i],b7[i+1]) for i in range(4)]
b8=[0,2.71,8.02,12.15,15.68,20.89,22.56,None]
p8=[trim(c[8],b8[i],b8[i+1]) for i in range(7)]
# câu cuối: bỏ khoảng lặng dài sau "Hoàng Hiệp"
last=c[8][int(22.56*SR):]; a1=trim(last,0,23.66-22.56); a2=trim(last,24.64-22.56,None)
p8[6]=a1+__import__("array").array("h",[0]*int(0.12*SR))+a2
pieces+=p8
import array
GAP=0.30; out=array.array("h"); times=[]
for i,p in enumerate(pieces):
    if i: out+=array.array("h",[0]*int(GAP*SR))
    st=len(out)/SR; out+=p; times.append([st,len(out)/SR])
tot=len(out)/SR; target=58.7; tempo=tot/target
open("raw.pcm","wb").write(out.tobytes())
subprocess.run(["ffmpeg","-v","error","-y","-f","s16le","-ar","44100","-ac","1","-i","raw.pcm","-af",f"atempo={tempo:.4f},loudnorm=I=-14:TP=-1.5,apad=pad_dur=2","-t","60","-ar","44100","../giong-doc.wav"],check=True)
times=[[round(a/tempo,3),round(b/tempo,3)] for a,b in times]
json.dump(times,open("../thoi-gian-cau.json","w"))
print(round(tot,2), round(tempo,3)); [print(i+1,t) for i,t in enumerate(times)]
