<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VideoInteractionController extends Controller
{
    public function login(Video $video): RedirectResponse
    {
        abort_unless($video->is_public, 404);

        if (auth()->check()) {
            return redirect()->route('public-videos.show', $video);
        }

        redirect()->setIntendedUrl(route('public-videos.show', $video));

        return redirect()->route('filament.admin.auth.login');
    }

    public function like(Video $video): RedirectResponse
    {
        abort_unless($video->is_public, 404);

        if (! auth()->check()) {
            return $this->login($video);
        }

        $like = $video->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        } else {
            $video->likes()->firstOrCreate(['user_id' => auth()->id()]);
        }

        return redirect()->route('public-videos.show', $video);
    }

    public function comment(Request $request, Video $video): RedirectResponse
    {
        abort_unless($video->is_public, 404);

        if (! auth()->check()) {
            return $this->login($video);
        }

        $data = $request->validate(['body' => ['required', 'string', 'min:1', 'max:1000']]);

        $video->comments()->create(['user_id' => auth()->id(), 'body' => $data['body']]);

        return redirect()->route('public-videos.show', $video)->with('status', 'Comentario publicado.');
    }
}
