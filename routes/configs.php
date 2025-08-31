<?php

use App\Http\Controllers\ClientConfigurations\ClientConfigurationController;
use Illuminate\Support\Facades\Route;

Route::prefix('configs')
    ->name('configs.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [ClientConfigurationController::class, 'index']);

        Route::post('/image', [ClientConfigurationController::class, 'updateImageSection'])->name('image');
        Route::delete('/image', [ClientConfigurationController::class, 'deleteImageSection'])->name('image');
        Route::post('/socials', [ClientConfigurationController::class, 'updateSocialsSection'])->name('socials');
        Route::post('/dynamic-questions', [ClientConfigurationController::class, 'updateDynamicQuestionsSection'])->name('questions');
    });
