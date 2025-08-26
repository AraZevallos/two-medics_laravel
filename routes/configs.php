<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('configs')
    ->name('configs.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('configs/Configurations');
        })
            ->name('index');
    });
