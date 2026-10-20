@echo off
chcp 65001 >nul
cd /d "%~dp0"
if not exist data\bot.pid (echo Bot khong chay. & pause & exit /b)
set /p P=<data\bot.pid
tasklist /FI "PID eq %P%" | find /I "python" >nul
if errorlevel 1 (echo Bot khong chay. & del data\bot.pid & pause & exit /b)
taskkill /PID %P% /F >nul
del data\bot.pid >nul 2>nul
echo Da tat bot.
pause
