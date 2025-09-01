<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('courses.index');
})->name('home');

Route::get('{any}', function () {
    return view('app'); // tu vista SPA
})->where('any', '.*');


require __DIR__ . '/auth.php';
require __DIR__ . '/configs.php';
require __DIR__ . '/courses.php';
require __DIR__ . '/settings.php';
