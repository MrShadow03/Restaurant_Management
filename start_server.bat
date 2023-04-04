@echo off
setlocal

set PROJECT_PATH=%~dp0
set XAMPP_PATH=C:\xampp

set PATH=%PATH%;%XAMPP_PATH%\php;%XAMPP_PATH%\php\ext

rem Open PowerShell in the project directory
start powershell.exe -NoExit -Command "cd %PROJECT_PATH% ; %XAMPP_PATH%\php\php.exe artisan serve"

rem Open a second PowerShell window in the project directory
start powershell.exe -NoExit -Command "cd %PROJECT_PATH% ; npm run dev"

rem Open a second PowerShell window in the project directory
start powershell.exe -NoExit -Command "cd %PROJECT_PATH% ; nodemon server.js"

start firefox.exe -new-tab "http://localhost:8000/"

endlocal
