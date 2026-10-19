<?php

use App\Http\Controllers\VideoStreamController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/videos/{video}/stream', [VideoStreamController::class, 'stream'])
    ->name('videos.stream');

Route::get('/videos/{video}/download', [VideoStreamController::class, 'download'])
    ->name('videos.download');
