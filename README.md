Esta prueba tecnica se realizo epor medio del framework laravel v8.Para la instalacion por favor seguir los siguientes pasos:<br>

1.Ejecutar composer para la instalación de las dependencias por medio del siguiente comando:<br>
composer install<br>
2.Tomar una copia del archivo .env.example y guardarlo en el mismo directorio con el nombre .env<br>
3. Generar la clave secreta por medio del siguiente comando:<br>
php artisan key:generate<br>
4.Crear la base de datos con el nombre que prefieras y actualizar los datos en las variables de entorno en el archivo .env <br>
5.Adicionar las siguientes variables de entorno en el archivo .env:.<br>
   PLACETOPAY_LOGIN='**************************'<br>
   PLACETOPAY_TRANKEY='**************************'<br>
6.Ejecutar las migraciones para crear las tablas por medio del siguiente comando:<br>
php artisan migrate<br>
7. Ejecutar los seeder de la tabla producto y users,por medio del siguiente comando:<br>
php artisan db:seed --class=ProductSeeder<br>
php artisan db:seed --class=AdminSeeder<br>
8.Para ingresar al panel admin para visualizar todas las ordenes de compra, se realiza por medio los siguientes accesos cargados en la base de datos previamente por medio del seeder AdminSeeder.php. <br>
email: Admin@placetopay.com<br>
password: qwerty12345<br>
