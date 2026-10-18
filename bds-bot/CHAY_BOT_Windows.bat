@echo off
chcp 65001 >nul
set PYTHONIOENCODING=utf-8
cd /d "%~dp0"
title BOT TU VAN BDS - dong cua so nay la bot dung
where py >nul 2>nul
if %errorlevel%==0 (py bot.py) else (python bot.py)
echo.
echo Bot da dung. Bam phim bat ky de dong.
pause >nul
