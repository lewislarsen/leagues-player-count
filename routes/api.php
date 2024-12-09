<?php

use App\Http\Controllers\Api\v1\AboutController;
use App\Http\Controllers\Api\v1\GameWorldController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Basic details about the api
    Route::get('/about', [AboutController::class, '__invoke'])->name('api.v1.about');

    // List worlds with filtering, sorting, and pagination
    Route::get('/worlds', [GameWorldController::class, 'index'])->name('api.v1.worlds.index');

    // Get worlds by specific world number
    Route::get('/worlds/number/{worldNumber}', [GameWorldController::class, 'listByWorldNumber'])->name('api.v1.worlds.byNumber');

    // Get worlds by specific activity
    Route::get('/worlds/activity/{worldActivity}', [GameWorldController::class, 'listByWorldActivity'])->name('api.v1.worlds.byActivity');

    // Advanced search
    Route::get('/worlds/search', [GameWorldController::class, 'search'])->name('api.v1.worlds.search');
});
