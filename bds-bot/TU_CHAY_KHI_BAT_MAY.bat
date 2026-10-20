@echo off
chcp 65001 >nul
cd /d "%~dp0"
set "S=%APPDATA%\Microsoft\Windows\Start Menu\Programs\Startup\BotTuVanBDS.vbs"
if exist "%S%" (
  del "%S%"
  echo Da TAT tu chay khi bat may.
) else (
  echo CreateObject^("WScript.Shell"^).Run "pythonw ""%~dp0bot.py""", 0, False> "%S%"
  echo Da BAT: moi lan bat may, bot tu chay an.
  echo Bam dup file nay lan nua de tat.
)
pause
