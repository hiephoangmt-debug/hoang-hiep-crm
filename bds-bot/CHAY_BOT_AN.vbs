' Chay bot AN (khong hien cua so). Tat bot: bam dup TAT_BOT.bat. Xem nhat ky: XEM_NHAT_KY.bat
Set fso = CreateObject("Scripting.FileSystemObject")
d = fso.GetParentFolderName(WScript.ScriptFullName)
Set sh = CreateObject("WScript.Shell")
sh.CurrentDirectory = d
sh.Run "pythonw """ & d & "\bot.py""", 0, False
WScript.Sleep 4000
MsgBox "Bot da chay an." & vbCrLf & vbCrLf & "- Kiem tra: nhan /thongke cho bot tren Zalo" & vbCrLf & "- Tat bot: bam dup TAT_BOT.bat" & vbCrLf & "- Xem nhat ky: bam dup XEM_NHAT_KY.bat", 64, "Bot tu van BDS"
