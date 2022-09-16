# Evertec Coding Challenge
Bienvenido a Evertec Coding Challenge

REQUERIMIENTOS:<br>
PHP 8.0.2 con SQLite driver activado si desea ejecutar las pruebas de las funcionalidades sobre una base de datos en memoria.

Para instalar el repositorio siga las siguientes instrucciones:<br>

1- Abra una terminal y ejecute:<br>
&nbsp;&nbsp;&nbsp;*git clone https://github.com/etiennez0r/evertec-cc*<br>
&nbsp;&nbsp;&nbsp;*cd evertec-cc*<br>
&nbsp;&nbsp;&nbsp;*composer install*<br>
&nbsp;&nbsp;&nbsp;*cp .env.example .env*<br>
<br>
2- Abra el archivo .env y configure la conexion a su base de datos y la clave de la aplicacion (APP_KEY=base64:nSl+HeaR8+8Hwp0HzQwL3v3jkJrMVyyBKKH7eU7KuKw=)<br>
<br>
3- Nuevamente en la terminal ejecute:<br> 
&nbsp;&nbsp;&nbsp;*php artisan migrate:fresh --seed* (para instalar la base de datos y generar datos ficticios de prueba)<br>
&nbsp;&nbsp;&nbsp;*vendor/bin/phpunit --filter=AppTest* (para verificar que las funcionalidades estan operativas)<br>

Nota: Si desea realizar las pruebas sobre una base de datos MySQL en lugar de SQLite edite las variables DB_CONNECTION y DB_DATABASE en el archivo phpunit.xml.

Ya puede navegar al url de su aplicacion y realizar las pruebas :)
