@extends('public-videos.layout')

@section('title', $video->title)

@section('content')
    <div class="video-detail section-wrap">
        <a class="text-link" href="{{ route('public-videos.index') }}">← Todos los videos</a>
        <div class="video-detail-heading">
            <span class="gallery-eyebrow">{{ $video->location }} · {{ $video->user->name }}</span>
            <h1>{{ $video->title }}</h1>
            @if ($video->description) <p>{{ $video->description }}</p> @endif
        </div>
        <video class="public-player" controls preload="metadata" playsinline aria-label="{{ $video->title }}">
            <source src="{{ route('videos.stream', $video) }}" type="{{ $video->mime_type }}">
            Tu navegador no admite la reproducción de video.
        </video>

        <div class="video-social">
            @auth
                <form method="POST" action="{{ route('public-videos.like', $video) }}">
                    @csrf
                    <button type="submit" class="social-button" aria-pressed="{{ $liked ? 'true' : 'false' }}">{{ $liked ? '♥ Te gusta' : '♡ Me gusta' }} · {{ $video->likes_count }}</button>
                </form>
            @else
                <a class="social-button" href="{{ route('public-videos.login', $video) }}">♡ Me gusta · {{ $video->likes_count }} <span>Inicia sesión</span></a>
            @endauth
            <span>{{ $video->comments_count }} comentarios</span>
        </div>

        <section class="video-comments" aria-labelledby="comments-title">
            <h2 id="comments-title">La conversación</h2>
            @auth
                <form method="POST" action="{{ route('public-videos.comments.store', $video) }}" class="comment-form">
                    @csrf
                    <label for="body">Deja un comentario</label>
                    <textarea name="body" id="body" rows="3" maxlength="1000" required placeholder="¿Qué te pareció este lugar?">{{ old('body') }}</textarea>
                    @error('body') <p role="alert" class="comment-error">{{ $message }}</p> @enderror
                    <button type="submit" class="button">Publicar comentario <span aria-hidden="true">↗</span></button>
                </form>
            @else
                <p class="comment-prompt"><a class="text-link" href="{{ route('public-videos.login', $video) }}">Inicia sesión</a> o <a class="text-link" href="{{ route('filament.admin.auth.register') }}">crea una cuenta</a> para comentar y dar me gusta.</p>
            @endauth

            <div class="comment-list">
                @forelse ($comments as $comment)
                    <article class="comment-item"><div><strong>{{ $comment->user->name }}</strong><time datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->format('d/m/Y') }}</time></div><p>{{ $comment->body }}</p></article>
                @empty
                    <p>Aún no hay comentarios. Sé la primera persona en compartir lo que piensas.</p>
                @endforelse
            </div>
            @if ($comments->hasPages()) <div class="comment-pages">{{ $comments->links() }}</div> @endif
        </section>
    </div>
@endsection
