<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Управление API токенами
    Route::post('/profile/tokens', [ProfileController::class, 'createToken'])->name('profile.tokens.create');
    Route::delete('/profile/tokens/{tokenId}', [ProfileController::class, 'destroyToken'])->name('profile.tokens.destroy');
});

Route::get('/', fn() => redirect()->route('clubs.index'));
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/clubs/trash', [ClubController::class, 'trash'])->name('clubs.trash');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{username}/clubs', [ClubController::class, 'userClubs'])->name('users.clubs');

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('clubs', ClubController::class);


Route::middleware('auth')->group(function () {
    Route::get('/clubs/trash', [ClubController::class, 'trash'])->name('clubs.trash');
    Route::post('/clubs/{id}/restore', [ClubController::class, 'restore'])->name('clubs.restore');
    Route::delete('/clubs/{id}/force', [ClubController::class, 'forceDestroy'])->name('clubs.force-destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/clubs/{club}/players',  [PlayerController::class, 'store'])->name('players.store');
    Route::delete('/players/{player}',    [PlayerController::class, 'destroy'])->name('players.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/comments/{club}',    [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});


Route::middleware('auth')->group(function () {
    Route::post('/friends/{id}', [FriendController::class, 'store'])->name('friends.store');
    Route::delete('/friends/{id}', [FriendController::class, 'destroy'])->name('friends.destroy');
});

Route::middleware('auth')->get('/feed', [FeedController::class, 'index'])->name('feed.index');

require __DIR__.'/auth.php';