#!/usr/bin/env python3
"""Tạo wordpress/tu-dong/cap-nhat/manifest.json + version.json cho tính năng Tự cập nhật (tu-cap-nhat.php).

Chạy SAU khi đã commit code (cây làm việc sạch), từ thư mục gốc kho:
    python3 wordpress/scripts/tao-cap-nhat.py
rồi commit 2 tệp trên và push; web tải từng tệp bằng đường dẫn có mã commit của bước trước.
"""
import hashlib, json, re, subprocess, sys

def git(*a):
    return subprocess.check_output(['git', *a]).decode()

commit = git('rev-parse', 'HEAD').strip()
if git('status', '--porcelain', '--untracked-files=no', '--', 'wordpress/wp-content/mu-plugins/hh-crm', 'wordpress/wp-content/themes/hoanghiep', 'wordpress/packaging').strip():
    sys.exit('Còn thay đổi chưa commit trong plugin/giao diện – commit trước rồi chạy lại.')
safe = re.compile(r'^[A-Za-z0-9._/@+-]+$')
files, skipped = [], []
def add(grp, rel, src):
    if rel.endswith(('.gitkeep', '.DS_Store')):
        return
    if not (safe.match(rel) and safe.match(src)):
        skipped.append(src); return
    data = subprocess.check_output(['git', 'show', f'{commit}:wordpress/{src}'])
    files.append([grp, rel, src, hashlib.sha256(data).hexdigest(), len(data)])

add('p', 'hoang-hiep-crm.php', 'packaging/hoang-hiep-crm.php')
for f in git('ls-files', 'wordpress/wp-content/mu-plugins/hh-crm').split('\n'):
    if f:
        add('p', 'hh-crm/' + f[len('wordpress/wp-content/mu-plugins/hh-crm/'):], f[len('wordpress/'):])
for f in git('ls-files', 'wordpress/wp-content/themes/hoanghiep').split('\n'):
    if f:
        add('t', f[len('wordpress/wp-content/themes/hoanghiep/'):], f[len('wordpress/'):])

pk = open('wordpress/packaging/hoang-hiep-crm.php', encoding='utf-8').read()
st = open('wordpress/wp-content/themes/hoanghiep/style.css', encoding='utf-8').read()
ver = re.search(r'Version:\s*([0-9.]+)', pk).group(1)
tver = re.search(r'Version:\s*([0-9.]+)', st).group(1)
man = json.dumps({'version': ver, 'theme': tver, 'commit': commit, 'files': files}, ensure_ascii=False, separators=(',', ':'))
open('wordpress/tu-dong/cap-nhat/manifest.json', 'w', encoding='utf-8').write(man)
v = {'version': ver, 'theme': tver, 'commit': commit, 'manifest_sha': hashlib.sha256(man.encode('utf-8')).hexdigest(), 'files': len(files)}
open('wordpress/tu-dong/cap-nhat/version.json', 'w', encoding='utf-8').write(json.dumps(v, ensure_ascii=False, indent=1) + '\n')
print(f'{ver} (giao diện {tver}) · commit {commit[:10]} · {len(files)} tệp' + (f' · bỏ qua {len(skipped)}: {skipped[:5]}' if skipped else ''))
