## Descripción

API desarrollada en laravel y mysql con Eloquent orm para las base de datos.

## Configuración

Crear la base de datos y conectarla a la app en el archivo .env .
Generar llave y pegarla en APP_KEY: en el archivo .env .

```
php artisan key:generate
```
Generar las tablas de la base de datos y insertar unos datos de prueba.
```
php artisan migrate:fresh --seed
```

Correr la aplicación
```
php artisan serve
```


