<h4 style="font-weight: bold;margin-top: 10px;">Descripción</h4>
  <p>API desarrollada en laravel y mysql con Eloquent orm para  las base de datos</p>
  <h4 style="font-weight: bold;margin-top: 10px;">Configuración</h4>
  <p>Crear la base de datos y conectarla a la app en el archivo .env</p>
  <p>Generar llave y pegarla en APP_KEY: en el archivo .env</p>
  `php artisan key:generate`
  <p style="margin-bottom:10px">Generar las tablas de la base de datos y insertar unos datos de prueba</p>
  `php artisan migrate:fresh --seed`
  <p style="margin-bottom:10px">Correr la aplicacion</p>
  `php artisan serve`

