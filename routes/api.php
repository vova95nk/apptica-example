<?php

use Illuminate\Support\Facades\Route;

Route::middleware('custom.throttle:5,1')->group(function () {
    Route::get('/stats', \App\Http\Actions\StatsAction::class)->name('stats');
});
