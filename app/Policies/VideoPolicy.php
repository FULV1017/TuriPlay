<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;

class VideoPolicy
{
    /**
     * Admins can perform any action on any video.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Video $video): bool
    {
        return $video->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Video $video): bool
    {
        return $video->user_id === $user->id;
    }

    public function delete(User $user, Video $video): bool
    {
        return $video->user_id === $user->id;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
