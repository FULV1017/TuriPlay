<?php

namespace App\Rules;

use App\Services\VideoMetadata;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MinVideoDuration implements ValidationRule
{
    public function __construct(
        protected int $minSeconds = 60,
        protected string $disk = 'local',
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (blank($value) || ! is_string($value)) {
            return;
        }

        $path = Storage::disk($this->disk)->path($value);

        try {
            $duration = app(VideoMetadata::class)->durationInSeconds($path);
        } catch (Throwable $e) {
            $fail('No se pudo leer la duración del video: '.$e->getMessage());

            return;
        }

        if ($duration < $this->minSeconds) {
            $fail("El video debe durar al menos {$this->minSeconds} segundos (1 minuto). Duración detectada: ".gmdate('i:s', (int) $duration).'.');
        }
    }
}
