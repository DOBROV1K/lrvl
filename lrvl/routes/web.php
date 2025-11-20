<?php

use App\Http\Controllers\ClubController;

Route::get('/', function () {
    return redirect()->route('clubs.index');
});

Route::resource('clubs', ClubController::class);

Route::get('/clubs/{club}', [ClubController::class, 'show'])->name('clubs.show');
