@echo off
echo Cerrando Servicios XAMPP...

rem This command stops the Apache service
taskkill /F /IM httpd.exe

rem This command stops the MySQL service
taskkill /F /IM mysqld.exe

echo XAMPP cerrado.
pause 
