# Contexto del proyecto · Sistema de Venta de Medicamentos (Farmacia San Juan Bautista)
 
> Este archivo es para el asistente de IA. Léelo completo antes de proponer código.
> Si una instrucción del usuario contradice este archivo, pregunta antes de continuar.
 
## 1. Entorno (no cambiar)
 
- Laravel 13, PHP 8.3, MySQL (Laragon en Windows). Proyecto en la carpeta `sistema/`.
- Bootstrap 5 y Bootstrap Icons ya cargados en la plantilla. Chart.js en `public/js/chart.umd.min.js`.
- Paquetes instalados: `barryvdh/laravel-dompdf` 3.x y `maatwebsite/excel` **4.x**.
- NO instales paquetes, NO cambies la versión de PHP o Laravel, NO ejecutes `composer update`.
- NO uses CDN nuevos: el laboratorio puede no tener internet.
 
## 2. Convenciones de código
 
- Nombres de tablas, columnas, modelos, controladores y rutas **en inglés**; textos de pantalla, comentarios y mensajes **en español**.
- Modelos con atributos de PHP: `#[Fillable([...])]` (no la propiedad `$fillable`). Relaciones con tipo de retorno (`BelongsTo`, `HasMany`).
- Controladores de recurso (`Route::resource`) con `->except('show')` si no hay vista de detalle.
- Validación con `$request->validate([...])` y `Rule::unique(...)->ignore($modelo->id)` al editar.
- Redirecciones con `to_route('modulo.index')->with('ok', 'Mensaje')` (verde) o `->with('error', 'Mensaje')` (rojo).
- Antes de eliminar un registro con hijos, comprobar con `->exists()` y devolver `with('error', ...)` (las FK son `restrictOnDelete()`).
- Listados con relaciones: `with('relacion')` para evitar N+1.
- Código comentado en español, explicando qué hace cada bloque (es un proyecto de enseñanza).
 
## 3. Vistas (Blade)
 
- Toda vista interna hereda la plantilla: `@extends('template.administrador')` (carpeta `template`, NO `layouts`).
- Secciones obligatorias: `title`, `name_section`, `description`, `item_section`, `route_section` (con `route(...)`), `section`, `module`, `content`.
- Carpetas: `settings/` (Configuraciones), `management/` (Gestión), `principal/` (Dashboard y Reportes). Cada módulo: `index`, `create`, `edit` y un `form.blade.php` compartido.
- Estructura visual: tarjeta `card bg-white border-0 shadow-sm border-5 border-top border-secondary`; botón "Nuevo registro" `btn btn-primary rounded-3 text-uppercase text-white`; tabla `id="display" class="table table-sm table-hover w-100 bg-white"`; acciones en un menú de tres puntos (`dropdown` con Editar y Eliminar).
- Mensajes: `@include('partials.alerts')`. Errores por campo: `@error('campo') <div class="invalid-feedback">{{ $message }}</div> @enderror` y `old('campo', $modelo->campo ?? '')`.
- JavaScript propio de una vista: `@push('scripts') ... @endpush`. NUNCA escribas `@json` dentro de un comentario `//`.
- Enlaces del menú en `resources/views/partials/sidebar.blade.php`, con la clase `active_item` cuando `request()->is(['modulo*'])`.
 
## 4. Seguridad y roles
 
- Roles (tabla `roles`, nombres exactos): `Administrador`, `Químico farmacéutico`, `Cajero`.
- `User::hasRole(...$roles)` y middleware `role` (alias en `bootstrap/app.php`).
- TODA ruta nueva va dentro de `Route::middleware('auth')->group(...)` en `routes/web.php`, y dentro del grupo de rol que corresponda:
  - Todos: dashboard, `customers`, `sales`.
  - `role:Administrador,Químico farmacéutico`: `medicines`, reportes.
  - `role:Administrador`: `categories`, `roles`, `users`; anular ventas.
- El menú se oculta con `@if (auth()->user()->hasRole(...))`, y además la ruta se protege con el middleware: ocultar no es proteger.
- El vendedor de una venta es siempre `auth()->id()`; nunca se elige en un formulario.
- NO instales Breeze, Jetstream ni Fortify. El login es manual (`LoginController`, `auth/login.blade.php`).
- NO pongas `id="loginForm"` en ningún formulario: `public/js/app.js` lo intercepta.
 
## 5. Base de datos (lo que ya existe)
 
| Tabla | Columnas principales |
|---|---|
| roles | id, name, description |
| users | id, role_id, name, dni, phone, tuition, email, password |
| categories | id, name, description |
| customers | id, name, dni, phone, age |
| medicines | id, category_id, name, price, stock, image |
| sales | id, customer_id, user_id, date, total, igv |
| detail_sales | id, sale_id, medicine_id, amount, price_unit, subtotal |
 
- La cantidad vendida es `amount` y el precio es `price_unit` (NO `quantity` ni `price` en `detail_sales`).
- El precio de venta **incluye** IGV: `igv = total * 18 / 118`.
- Las ventas se registran dentro de `DB::transaction()` y descuentan stock con `lockForUpdate()`.
- Para cambiar una tabla existente se crea una **migración nueva** (`add_..._to_..._table`); nunca se edita una migración ya ejecutada.
- Cada tabla nueva tiene su seeder en `database/seeders` y se registra en `DatabaseSeeder` respetando el orden de las FK.
 
## 6. Idioma
 
- `APP_LOCALE=es`. Los mensajes de validación están en `lang/es/validation.php`; agrega ahí el nombre legible (`attributes`) de cada campo nuevo.
 
## 7. Forma de responder
 
- Antes de escribir código, lista los archivos que vas a crear o modificar.
- Entrega cada archivo **completo** con su ruta, salvo que se pida solo un fragmento.
- Indica los comandos de Artisan necesarios (`make:model`, `migrate`, etc.) en orden.
- Al final, explica en 5 líneas cómo probarlo y qué podría fallar.
