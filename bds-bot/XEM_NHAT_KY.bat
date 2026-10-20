@echo off
cd /d "%~dp0"
if not exist data\bot.log (echo Chua co nhat ky. & pause & exit /b)
start "" notepad data\bot.log
