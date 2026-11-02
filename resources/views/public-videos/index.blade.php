@extends('public-videos.layout')

@section('title', 'Explorar videos')

@section('content')
    <section class="gallery-intro section-wrap" aria-labelledby="gallery-title">
        <span class="gallery-eyebrow">TURIPLAY · COMUNIDAD</span>
        <h1 id="gallery-title">Viajes para <span>compartir.</span></h1>
        <p>Descubre el Perú a través de las historias que otros viajeros decidieron compartir.</p>
    </section>

    <section class="gallery-list section-wrap" aria-label="Videos públicos">
        @forelse ($videos as $video)
            <article class="gallery-card">
                <a href="{{ route('public-videos.show', $video) }}" aria-label="Ver {{ $video->title }}">
                    <span class="gallery-card-art" aria-hidden="true"><span class="gallery-play">▶</span><span class="gallery-card-place">{{ $video->location }}</span></span>
                    <span class="gallery-card-copy"><span class="gallery-card-caption">{{ $video->user->name }} · {{ gmdate('i:s', $video->duration_seconds) }}</span><h3>{{ $video->title }}</h3><span class="gallery-card-stats">{{ $video->likes_count }} me gusta · {{ $video->comments_count }} comentarios</span></span>
                </a>
            </article>
        @empty
            <div class="gallery-empty"><h2>Aún no hay videos públicos</h2><p>Cuando alguien decida compartir su viaje, podrás encontrarlo aquí.</p><a class="button" href="{{ route('filament.admin.auth.register') }}">Comienza a compartir <span aria-hidden="true">↗</span></a></div>
        @endforelse
    </section>

    @if ($videos->hasPages())
        <nav class="gallery-pagination section-wrap" aria-label="Páginas de videos">
            @if ($videos->previousPageUrl()) <a href="{{ $videos->previousPageUrl() }}">← Anteriores</a> @endif
            <span>Página {{ $videos->currentPage() }} de {{ $videos->lastPage() }}</span>
            @if ($videos->nextPageUrl()) <a href="{{ $videos->nextPageUrl() }}">Siguientes →</a> @endif
        </nav>
    @endif
@endsection
