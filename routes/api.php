<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;

Route::post('/shorten', [ShortUrlController::class, 'shorten']);