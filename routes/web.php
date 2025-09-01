<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('courses.index');
})->name('home');

Route::get('/{any}', function () {
    $countParents = Course::whereNull('parent_id')->count();
    $countCourses = Course::whereNotNull('parent_id')->count();
    $countVisibles = Course::whereNotNull('parent_id')->where('is_visible', true)->count();

    return Inertia::render('courses/Courses', [
        'summary' => [
            'parents' => $countParents,
            'courses' => $countCourses,
            'visibles' => $countVisibles,
        ]
    ]);
})->where('any', '.*');


require __DIR__ . '/auth.php';
require __DIR__ . '/configs.php';
require __DIR__ . '/courses.php';
require __DIR__ . '/settings.php';
