Esta prueba tecnica se realizo en laravel v8.Para la instalacion por favor seguir los siguientes pasos:

1.Ejecutar composer para la instalación de las dependencias por medio del siguiente comando:
composer install
2.Tomar una copia del archivo .env.example y guardarlo en el mismo directorio con el nombre .env
3. Generar la clave secreta por medio del siguiente comando:
php artisan key:generate
4.Crear la base de datos con el nombre que prefieras y actualizar los datos en las variables de entorno en el archivo .env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

5.Adicionar las siguientes variables de entorno en el archivo .env:.
   PLACETOPAY_LOGIN='**************************'
   PLACETOPAY_TRANKEY='**************************'
6.Ejecutar las migraciones para crear las tablas por medio del siguiente comando:
php artisan migrate
7. Ejecutar los seeder de la tabla producto y users,por medio del siguiente comando:
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=AdminSeeder
8.Para ingresar al panel admin para visualizar todas las ordenes de compra, se realiza por medio los siguientes accesos cargados en la base de datos previamente por medio del seeder AdminSeeder.php.
email: Admin@placetopay.com
password: qwerty12345
