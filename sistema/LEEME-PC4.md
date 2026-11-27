# Sistema de Venta de Medicamentos (FARM SJB) – PC4

Instalación (Laragon, terminal de Laragon, dentro de la carpeta `sistema`):

```
composer install
composer require barryvdh/laravel-dompdf maatwebsite/excel
copy .env.example .env
php artisan key:generate
mysql -u root -e "CREATE DATABASE farmacia"
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Usuarios de prueba (contraseña `password`):

| Correo | Rol |
|---|---|
| admin@sanjuan.com | Administrador |
| rquispe@sanjuan.com | Químico farmacéutico |
| cmendoza@sanjuan.com | Cajero |
| ltorres@sanjuan.com | Cajero |

Módulos: Login/Logout, Roles, Categorías, Usuarios, Clientes, Medicamentos, Ventas,
Dashboard (Chart.js en `public/js/chart.umd.min.js`) y Reporte de ventas con filtros
(exporta a PDF con DOMPDF y a Excel con maatwebsite/excel).
