<?php

use App\Http\Controllers\PublicVideoController;
use App\Http\Controllers\VideoInteractionController;
use App\Http\Controllers\VideoStreamController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check()
    ? redirect()->to('/admin')
    : view('landing'))->name('landing');

Route::get('/videos/{video}/stream', [VideoStreamController::class, 'stream'])
    ->name('videos.stream');

Route::get('/videos/{video}/download', [VideoStreamController::class, 'download'])
    ->name('videos.download');

Route::get('/explorar', [PublicVideoController::class, 'index'])->name('public-videos.index');
Route::get('/explorar/{video}', [PublicVideoController::class, 'show'])->name('public-videos.show');
Route::get('/explorar/{video}/participar', [VideoInteractionController::class, 'login'])->name('public-videos.login');
Route::post('/explorar/{video}/like', [VideoInteractionController::class, 'like'])->middleware('throttle:30,1')->name('public-videos.like');
Route::post('/explorar/{video}/comentarios', [VideoInteractionController::class, 'comment'])->middleware('throttle:5,1')->name('public-videos.comments.store');
