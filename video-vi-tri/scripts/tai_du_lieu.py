# Tải 1 lớp dữ liệu Overture Maps trong khung tọa độ, xuất GeoJSON.
# python3 tai_du_lieu.py <theme> <type> <file.geojson> <xmin,ymin,xmax,ymax> [cột,...]
import os, sys, json, time
import pyarrow.fs as pafs, pyarrow.dataset as ds, pyarrow.compute as pc
import shapely.wkb, shapely.geometry as sg
REL="2026-09-23.1"
theme, typ, out = sys.argv[1], sys.argv[2], sys.argv[3]
xmin,ymin,xmax,ymax = map(float, sys.argv[4].split(","))
cols = sys.argv[5].split(",") if len(sys.argv)>5 else None
proxy = os.environ.get("HTTPS_PROXY") or os.environ.get("https_proxy")
fs = pafs.S3FileSystem(anonymous=True, region="us-west-2", **({"proxy_options": proxy} if proxy else {}))
d = ds.dataset(f"overturemaps-us-west-2/release/{REL}/theme={theme}/type={typ}/", filesystem=fs, format="parquet")
f = (pc.field("bbox","xmin") < xmax) & (pc.field("bbox","xmax") > xmin) & (pc.field("bbox","ymin") < ymax) & (pc.field("bbox","ymax") > ymin)
t0=time.time()
want = ["geometry"] + (cols or [])
want = [c for c in want if c in d.schema.names]
tbl = d.to_table(filter=f, columns=want)
feats=[]
for row in tbl.to_pylist():
    g = shapely.wkb.loads(row.pop("geometry"))
    feats.append({"type":"Feature","geometry":sg.mapping(g),"properties":row})
json.dump({"type":"FeatureCollection","features":feats}, open(out,"w"), ensure_ascii=False, default=str)
print(typ, len(feats), round(time.time()-t0,1),"s", file=sys.stderr)
