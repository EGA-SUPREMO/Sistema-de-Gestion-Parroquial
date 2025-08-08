@echo off
echo Iniciando servicios de XAMPP...

rem Change this path if your XAMPP installation is in a different location
cd "C:\xampp"

echo Iniciando Apache...
start "" /B "apache\bin\httpd.exe"

echo Iniciando MySQL...
start "" /B "mysql\bin\mysqld.exe"

rem Open a browser to localhost after a short delay
echo Esperando los servicios para comenzar...
timeout /t 5 >nul
echo Abriendo Navegador en localhost...
start "" "http://localhost/dashboard"

echo Los servicios de XAMPP y el navegador estan abiertos.
echo NO cierre esta ventana mientras usa el sistema de gestion.
pause	