<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/clubs/trash', [ClubController::class, 'trash'])->name('clubs.trash');
});

Route::get('/', function () {
    return redirect()->route('clubs.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('clubs', ClubController::class);


Route::middleware(['auth'])->group(function () {
    Route::post('/clubs/{id}/restore', [ClubController::class, 'restore'])->name('clubs.restore');
    Route::delete('/clubs/{id}/force', [ClubController::class, 'forceDestroy'])->name('clubs.force-destroy');
});

Route::get('/users/{username}/clubs', [ClubController::class, 'userClubs'])->name('users.clubs');

require __DIR__.'/auth.php';