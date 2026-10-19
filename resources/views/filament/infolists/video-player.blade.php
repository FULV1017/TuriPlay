@php
    $record = $getRecord();
@endphp

@if ($record)
    <video class="w-full rounded-lg bg-black" controls preload="metadata">
        <source src="{{ route('videos.stream', $record) }}" type="{{ $record->mime_type }}">
        Tu navegador no admite la reproducción de video.
    </video>
@endif
