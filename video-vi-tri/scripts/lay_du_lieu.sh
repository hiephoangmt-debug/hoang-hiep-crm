#!/usr/bin/env bash
# Tải dữ liệu bản đồ mở (Overture Maps) cho khu vực rồi rút gọn vào public/data.
# Cần: pip install pyarrow shapely
set -e
cd "$(dirname "$0")/.."
mkdir -p data
W=108.14,15.83,108.40,16.11      # vùng rộng: biển, sông, đường, ranh giới
N=108.215,15.975,108.30,16.065   # vùng gần dự án: tòa nhà 3D
python3 scripts/tai_du_lieu.py base water data/water.geojson $W subtype,class,names &
python3 scripts/tai_du_lieu.py base land data/land.geojson $W subtype,class &
python3 scripts/tai_du_lieu.py base land_use data/land_use.geojson $W subtype,class &
python3 scripts/tai_du_lieu.py transportation segment data/segment.geojson $W subtype,class,names &
python3 scripts/tai_du_lieu.py buildings building data/building.geojson $N height,num_floors,class &
python3 scripts/tai_du_lieu.py divisions division_area data/division_area.geojson $W subtype,class,names,admin_level &
wait
python3 scripts/xu_ly_du_lieu.py data public/data
