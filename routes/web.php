<?php

use App\Http\Controllers\LogReadingController;
use App\Http\Controllers\ReadingLogController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// Route::inertia('/', 'Welcome', [
//     'canRegister' => Features::enabled(Features::registration()),
// ])->name('home');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ReadingLogController::class, 'index'])->name('dashboard');
    Route::get('/log-reading', [LogReadingController::class, 'index'])->name('log-reading');
    Route::get('/book-search', [LogReadingController::class, 'bookSearch'])->name('book-search');
    Route::get('/book-cover', [LogReadingController::class, 'bookCover'])->name('book-cover');
});

require __DIR__.'/settings.php';
