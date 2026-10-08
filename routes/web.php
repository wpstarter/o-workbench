<?php

use WpStarter\Support\Facades\Route;
use Orchestra\Workbench\Http\Controllers\ProfileController;

// Route::get('/', function () {
//     return ws_view('welcome');
// });

Route::get('/dashboard', function () {
    return ws_view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
