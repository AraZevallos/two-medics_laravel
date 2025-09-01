<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\CursoController;
use App\Http\Controllers\Client\ConfigController;

Route::prefix('client')->group(function () {
    Route::get('courses/{code}/pdf', [CursoController::class, 'downloadByCode']);
    Route::get('configuration', [ConfigController::class, 'getConfiguration']);
});
