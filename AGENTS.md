# Plataforma Turistica — Guía para agentes

App Laravel 13 + Filament 5 (panel admin en `/admin`). Videos turísticos (≥1 min) en disco
privado con auth SQLite: subir, ver y descargar.

## Antes de trabajar
Instala Laravel Boost (solo dev). Regenera este archivo con guías adaptadas a la app:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Si no hay red, continúa con las indicaciones de abajo.

## Comandos
- Setup inicial: `composer setup` (install, .env, key:generate, migrate, npm build).
- Dev todo-en-uno: `composer dev` -> `php artisan dev` levanta `serve` + `queue:listen` + `vite`.
- Assets: `npm run dev` / `npm run build`.
- Tests: `composer test` (hace `config:clear` y corre `artisan test`).
  Un solo test: `php artisan test --filter=Nombre` o `php artisan test tests/Feature/Archivo.php`.
- Formato: `vendor/bin/pint` (Pint instalado, sin script en composer.json ni `pint.json`).
- Asignar rol por correo: `php artisan user:role {email} {role=admin}` (`app/Console/Commands/SetUserRoleCommand.php`).

## Entorno
- PHP ^8.3 (instalado 8.5). SQLite por defecto (`database/database.sqlite`).
- `SESSION_DRIVER`, `QUEUE_CONNECTION` y `CACHE_STORE` = `database` -> requiere `php artisan migrate`.
- `.npmrc` fija `ignore-scripts=true` (por eso el setup usa `npm install --ignore-scripts`).
- Locale `es` (`APP_LOCALE`/`APP_FALLBACK_LOCALE` en `.env`); mensajes en `lang/es/` generados con
  `laravel-lang/common` -> `php artisan lang:add es`.

## Arquitectura
- Sin `app/Http/Kernel.php`: middleware y manejo de excepciones en `bootstrap/app.php`; health en `/up`.
- Filament: `app/Providers/Filament/AdminPanelProvider.php` (ruta `/admin`, brand `TuriPlay`) autodescubre
  `app/Filament/{Resources,Pages,Widgets}`; genera con `php artisan make:filament-resource`.
  Auth con `->login()` y `->registration()` (`/admin/register`); el registro usa la página de Filament y
  crea al usuario con rol `user` (default de la columna).
- Entrypoints de Vite: `resources/css/app.css` y `resources/js/app.js`; Tailwind v4 vía `@tailwindcss/vite`.

## Dominio de videos
- `app/Models/Video.php` + `app/Filament/Resources/Videos/` (subir, listar, editar, ver, borrar).
- El archivo va al disco `local` (privado) en `videos/`; se borra del disco al eliminar el registro.
- Duración mínima 60s validada con ffprobe vía `App\Rules\MinVideoDuration` / `App\Services\VideoMetadata`
  (binario configurable con `FFPROBE_PATH`, default `ffprobe`).
- El `user_id` es el usuario logueado; cada usuario solo ve y gestiona sus videos (ver Roles).
- Ver/descargar: rutas `videos.stream` y `videos.download` (`VideoStreamController`), con `auth` propio
  y `Gate::authorize('view', $video)` (`App\Policies\VideoPolicy`).
- Límite de subida: lo impone Livewire en `config/livewire.php` (`temporary_file_upload.rules`, `max:512000`),
  no `php.ini`; debe coincidir con el `->maxSize(512000)` de `VideoForm`.
- Usuario admin de ejemplo: `admin@turiplay.com` (crear más con `php artisan make:filament-user`).

## Roles y autorización
- `App\Enums\UserRole` (`admin` / `user`); columna `users.role` (string, default `user`), cast en `User::casts()`.
- Helpers: `User::isAdmin()`; factory `User::factory()->admin()`.
- `App\Policies\VideoPolicy`: `before()` deja pasar a admins; usuarios solo su `user_id`; `deleteAny` = false
  (los admins pueden por `before`).
- `VideoResource::getEloquentQuery()` filtra la lista y el route-binding a los videos propios si no es admin;
  `getNavigationLabel()` devuelve "Mis videos" / "Videos turísticos". `VideosTable` oculta la columna
  `user.name` a no-admins.
- `UserResource` (`/admin/users`) es solo para admins (overrides `canViewAny/canCreate/canEdit/canDelete`).
- Widgets (`app/Filament/Widgets/`): `MyVideosStats` (<- no admin), `AdminGlobalStats` y
  `AdminUserVideosStats` (<- admin). El último usa `Select` con `statePath('')` + `->live()` para elegir
  usuario; vista en `resources/views/filament/widgets/admin-user-videos-stats.blade.php`.

## Convenciones (Laravel 13)
- Los modelos configuran fillable/hidden con atributos PHP, no con propiedades:
  `#[Fillable([...])]` y `#[Hidden([...])]` (ver `app/Models/User.php`).

## Tests
- PHPUnit 12 (no Pest). Suites `tests/Unit` y `tests/Feature`. SQLite `:memory:`.
- `tests/TestCase.php` no incluye `RefreshDatabase` por defecto.
