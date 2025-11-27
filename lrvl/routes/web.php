<?php

use App\Http\Controllers\ClubController;

Route::get('/', function () {
    return redirect()->route('clubs.index');
});

Route::resource('clubs', ClubController::class);

