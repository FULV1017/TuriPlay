<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Contracts\View\View;

class PublicVideoController extends Controller
{
    public function index(): View
    {
        return view('public-videos.index', [
            'videos' => Video::public()->with('user:id,name')->withCount(['likes', 'comments'])->latest('id')->paginate(12),
        ]);
    }

    public function show(Video $video): View
    {
        abort_unless($video->is_public, 404);

        $video->load('user:id,name')->loadCount(['likes', 'comments']);

        return view('public-videos.show', [
            'video' => $video,
            'comments' => $video->comments()->with('user:id,name')->oldest()->paginate(15),
            'liked' => auth()->check() && $video->likes()->where('user_id', auth()->id())->exists(),
        ]);
    }
}
