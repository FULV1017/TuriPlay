<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#142c28">
    <meta name="description" content="Explora videos turísticos compartidos por la comunidad de TuriPlay.">
    <title>@yield('title') — TuriPlay</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite('resources/css/app.css')
</head>
<body class="turiplay-landing public-gallery">
    <a class="skip-link" href="#contenido">Saltar al contenido</a>
    <header class="site-header">
        <a class="brand" href="{{ route('landing') }}" aria-label="TuriPlay, inicio"><span class="brand-symbol" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m9 5 11 7-11 7Z"/></svg></span>TuriPlay<span class="brand-dot">.</span></a>
        <nav class="main-nav" aria-label="Navegación principal"><a href="{{ route('public-videos.index') }}" @if (request()->routeIs('public-videos.index')) aria-current="page" @endif>Explorar videos</a><a href="{{ route('landing') }}">Inicio</a></nav>
        <div class="header-actions">
            @auth
                <a class="login-link" href="/admin">Mi espacio</a>
            @else
                <a class="login-link" href="{{ route('filament.admin.auth.login') }}">Iniciar sesión</a>
                <a class="button button-small" href="{{ route('filament.admin.auth.register') }}">Crear una cuenta <span aria-hidden="true">↗</span></a>
            @endauth
        </div>
    </header>
    <main id="contenido">@yield('content')</main>
    <footer class="site-footer"><a class="brand" href="{{ route('landing') }}">TuriPlay<span class="brand-dot">.</span></a><p>El Perú se vive. Tus historias se quedan.</p><a href="{{ route('public-videos.index') }}">Explorar videos <span aria-hidden="true">↗</span></a></footer>
</body>
</html>
