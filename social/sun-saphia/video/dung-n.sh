#!/bin/sh
for d in n*/; do d=${d%/}; [ -f $d/$d.mp4 ] || python3 render.py $d/scenes.json $d/$d.mp4 || exit 1; done
