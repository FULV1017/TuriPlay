<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id',
    'title',
    'description',
    'location',
    'duration_seconds',
    'mime_type',
    'size_bytes',
    'path',
    'is_public',
])]
class Video extends Model
{
    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(VideoLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(VideoComment::class);
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'duration_seconds' => 'integer',
            'size_bytes' => 'integer',
            'is_public' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Video $video): void {
            if ($video->path) {
                Storage::disk('local')->delete($video->path);
            }
        });
    }
}
