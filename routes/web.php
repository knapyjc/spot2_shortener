<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;

Route::get('/', [ShortUrlController::class, 'list'])->name('shortener.list');
Route::post('/shorten', [ShortUrlController::class, 'shorten'])->name('shortener.shorten');
Route::get('/shorten', [ShortUrlController::class, 'form'])->name('shorten.form');
Route::get('/{code}', [ShortUrlController::class, 'redirect']);
Route::delete('/urls/{id}', [ShortUrlController::class, 'destroy'])->name('shortener.destroy');

