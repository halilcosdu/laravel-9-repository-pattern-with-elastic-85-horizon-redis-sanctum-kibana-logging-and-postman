<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/activities', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/activities/{activity_id}', [ActivityController::class, 'show'])->name('activity.show');
    Route::delete('/activities', [ActivityController::class, 'destroy'])->name('activity.destroy');
});
