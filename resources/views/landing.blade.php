<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TuriPlay: tu espacio para subir, visualizar y descargar videos turísticos. Conserva tus viajes por el Perú en movimiento.">
    <meta name="theme-color" content="#142c28">
    <title>TuriPlay — Explora el Perú en movimiento</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}?v=turiplay-1" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v=turiplay-1" type="image/x-icon">
    <link rel="preload" href="{{ Vite::asset('resources/fonts/barlow-condensed-semibold.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="{{ asset('images/landing/machu-picchu.jpg') }}" as="image">
    @vite('resources/css/app.css')
</head>
<body class="turiplay-landing">
    <a class="skip-link" href="#contenido">Saltar al contenido</a>
    <header class="site-header">
        <a class="brand" href="{{ route('landing') }}" aria-label="TuriPlay, inicio"><span class="brand-symbol" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m9 5 11 7-11 7Z"/></svg></span>TuriPlay<span class="brand-dot">.</span></a>
        <nav class="main-nav" aria-label="Navegación principal"><a href="{{ route('public-videos.index') }}">Explorar videos</a><a href="#que-es">Qué es TuriPlay</a><a href="#como-funciona">Cómo funciona</a></nav>
        <div class="header-actions"><a class="login-link" href="{{ route('filament.admin.auth.login') }}">Iniciar sesión</a><a class="button button-small" href="{{ route('filament.admin.auth.register') }}">Crear una cuenta <span aria-hidden="true">↗</span></a></div>
    </header>
    <main id="contenido">
        <section class="hero" aria-labelledby="hero-title">
            <img class="hero-image" src="{{ asset('images/landing/machu-picchu.jpg') }}" alt="Terrazas de Machu Picchu entre las montañas verdes de los Andes peruanos" width="2000" height="1333" fetchpriority="high">
            <div class="hero-shade"></div>
            <div class="hero-content">
                <h1 id="hero-title">Explora el Perú<br>en <span>movimiento.</span></h1>
                <p>Hay lugares que no caben en una foto.<br>Guarda tus viajes en video y vuelve a vivirlos con TuriPlay.</p>
                <a class="button" href="{{ route('filament.admin.auth.register') }}">Crear mi cuenta <span aria-hidden="true">↗</span></a>
                <a class="hero-more" href="{{ route('public-videos.index') }}">Explorar videos <span aria-hidden="true">↗</span></a>
            </div>
            <div class="hero-bottom"><span>Tu próxima historia empieza aquí.</span><span class="location"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>Machu Picchu · Cusco, Perú</span></div>
        </section>
        <section class="intro section-wrap" id="que-es" aria-labelledby="intro-title">
            <h2 id="intro-title">El viaje pasa.<br><span>La historia se queda.</span></h2>
            <div class="intro-copy"><p>TuriPlay es tu espacio para conservar videos turísticos. Reúne tus recorridos, paisajes y momentos en un solo lugar, desde tu propia cuenta.</p><p>Sube lo que grabaste, vuelve a verlo y descárgalo cuando quieras revivir el camino.</p><a class="text-link" href="{{ route('filament.admin.auth.register') }}">Empieza tu colección <span aria-hidden="true">↗</span></a></div>
        </section>
        <section class="discover-band section-wrap" aria-labelledby="discover-title">
            <div><span class="gallery-eyebrow">HISTORIAS ABIERTAS</span><h2 id="discover-title">Mira el Perú<br><span>con otros ojos.</span></h2><p>Algunos viajeros comparten sus recorridos para que tú también puedas descubrirlos. Verlos es gratis; para comentar o dar me gusta, crea tu cuenta.</p></div>
            <a class="button" href="{{ route('public-videos.index') }}">Explorar videos <span aria-hidden="true">↗</span></a>
        </section>
        <section class="features section-wrap" aria-labelledby="features-title">
            <div class="feature-heading"><h2 id="features-title">Tus recuerdos.<br>Tu espacio.</h2><p>Del primer paisaje al último recorrido,<br>mantén tus videos a mano.</p></div>
            <div class="feature-list">
                <article><svg class="feature-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 16V3m-5 5 5-5 5 5M4 16v5h16v-5"/></svg><div><h3>Sube tus historias</h3><p>Conserva tus videos turísticos de un minuto o más en tu cuenta.</p></div></article>
                <article><svg class="feature-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="m10 8 6 4-6 4Z"/></svg><div><h3>Vuelve a estar ahí</h3><p>Reproduce tus videos y revive esos lugares desde tu espacio personal.</p></div></article>
                <article><svg class="feature-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v13m-5-5 5 5 5-5M4 17v4h16v-4"/></svg><div><h3>Llévalos contigo</h3><p>Descarga tus archivos para conservar una copia de tus recorridos.</p></div></article>
            </div>
            <p class="privacy-note"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>Tus videos son privados por defecto. Tú eliges cuáles compartir en Explorar; solo entonces podrán verlos otras personas.</p>
        </section>
        <section class="how section-wrap" id="como-funciona" aria-labelledby="how-title">
            <div class="how-title"><h2 id="how-title">Menos pasos.<br>Más recuerdos.</h2><p>Así empieza tu historia en TuriPlay.</p></div>
            <ol class="steps"><li><span class="step-number" aria-hidden="true">1</span><div><h3>Crea tu cuenta</h3><p>Regístrate para acceder a tu espacio personal.</p></div></li><li><span class="step-number" aria-hidden="true">2</span><div><h3>Sube tu video</h3><p>Elige ese recorrido que merece quedarse contigo.</p></div></li><li><span class="step-number" aria-hidden="true">3</span><div><h3>Revive el viaje</h3><p>Visualiza, administra y descarga tus videos desde el panel.</p></div></li></ol>
        </section>
        <section class="closing" aria-labelledby="closing-title"><div><h2 id="closing-title">Que tu próximo viaje<br>no se quede solo en tu memoria.</h2><p>Dale un lugar a tus historias con TuriPlay.</p></div><a class="button button-dark" href="{{ route('filament.admin.auth.register') }}">Crear mi cuenta <span aria-hidden="true">↗</span></a></section>
    </main>
    <footer class="site-footer"><a class="brand" href="{{ route('landing') }}">TuriPlay<span class="brand-dot">.</span></a><p>El Perú se vive. Tus historias se quedan.</p><a href="{{ route('filament.admin.auth.login') }}">Iniciar sesión <span aria-hidden="true">↗</span></a></footer>
</body>
</html>
