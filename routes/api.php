<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::controller(TaskController::class)->group(function () {
    Route::get('task', 'get');
    Route::post('task', 'store');
    Route::match(['put', 'patch'], 'task/{id}', 'update');
    Route::delete('task/{id}', 'destroy');
});
