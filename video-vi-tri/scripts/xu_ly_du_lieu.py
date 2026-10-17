# Rút gọn dữ liệu Overture thành các lớp nhẹ cho bản đồ: biển, đất, cây xanh, đường, tòa nhà, ranh giới Hội An.
# python3 xu_ly_du_lieu.py <thư mục data> <thư mục public/data>
import json, random, sys, os
from shapely.geometry import shape, mapping, box
from shapely.ops import unary_union
D=sys.argv[1]; O=sys.argv[2]; os.makedirs(O,exist_ok=True)
BB=box(108.14,15.83,108.40,16.11)
def load(n): return json.load(open(f"{D}/{n}.geojson"))["features"]
def rnd(o):
    if isinstance(o,float): return round(o,6)
    if isinstance(o,(list,tuple)): return [rnd(x) for x in o]
    if isinstance(o,dict): return {k:rnd(v) for k,v in o.items()}
    return o
def save(n,feats):
    json.dump({"type":"FeatureCollection","features":[rnd(f) for f in feats]},open(f"{O}/{n}.geojson","w"),ensure_ascii=False,separators=(",",":"))
    print(n,len(feats),os.path.getsize(f"{O}/{n}.geojson")//1024,"KB")
def F(g,p=None): return {"type":"Feature","geometry":mapping(g),"properties":p or {}}
# land mass = Vietnam polygon clipped
BB2=box(108.0,15.6,108.55,16.25)
ocean=unary_union([shape(f["geometry"]) for f in load("water") if f["properties"]["subtype"]=="ocean"]).intersection(BB2)
land=BB2.difference(ocean)
save("ocean",[F(ocean)])
save("landmass",[F(land)])
# inland water
w=[F(shape(f["geometry"]).intersection(BB)) for f in load("water") if f["properties"]["subtype"]!="ocean" and f["geometry"]["type"] in("Polygon","MultiPolygon")]
save("water",[x for x in w if x["geometry"]["coordinates"]])
# green + sand
green=[];sand=[]
for f in load("land"):
    if f["geometry"]["type"] not in("Polygon","MultiPolygon"): continue
    c=f["properties"]["class"]; s=f["properties"]["subtype"]
    if c in("beach",) or s=="sand": sand.append(F(shape(f["geometry"])))
    elif s in("tree","forest","grass","shrub","wetland"): green.append(F(shape(f["geometry"])))
for f in (load("land_use") if os.path.exists(f"{D}/land_use.geojson") else []):
    if f["geometry"]["type"] in("Polygon","MultiPolygon") and f["properties"]["subtype"] in("park","recreation"):
        green.append(F(shape(f["geometry"])))
save("green",green); save("sand",sand)
# roads
R={"motorway":5,"trunk":5,"primary":4,"secondary":3,"tertiary":2,"residential":1,"living_street":1,"unclassified":1,"service":0}
roads=[]
for f in load("segment"):
    if f["properties"]["subtype"]!="road": continue
    r=R.get(f["properties"]["class"])
    if r is None: continue
    n=(f["properties"].get("names") or {}).get("primary")
    roads.append({"type":"Feature","geometry":f["geometry"],"properties":{"r":r,"n":n}})
save("roads",roads)
# buildings w/ synthetic height
random.seed(7); b=[]
for f in load("building"):
    g=shape(f["geometry"])
    if g.geom_type not in("Polygon","MultiPolygon"): continue
    p=f["properties"]; h=p.get("height") or (p.get("num_floors") or 0)*3.4
    if not h:
        a=g.area*1.2e10  # ~m2
        h = random.choice([7,10,10,13,14,17]) if a<400 else random.uniform(10,22) if a<2500 else random.uniform(14,40)
    b.append(F(g,{"h":round(h,1)}))
save("buildings",b)
# Hoi An boundary
ha=[shape(f["geometry"]) for f in load("division_area") if (f["properties"].get("names") or {}).get("primary") in("Phường Hội An","Phường Hội An Đông","Phường Hội An Tây") and f["properties"].get("class")=="land"]
save("hoian",[F(unary_union(ha).buffer(0).simplify(0.0001))])
