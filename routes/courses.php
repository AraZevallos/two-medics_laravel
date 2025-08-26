<?php

use App\Http\Controllers\Courses\CourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('cursos')
    ->name('courses.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [CourseController::class, 'index'])
            ->name('index');

        Route::get('/parent/{parent}', [CourseController::class, 'parent'])
            ->name('parent');

        Route::get('/parent/{parent}/course/{course}', [CourseController::class, 'course'])
            ->name('course');

        Route::post('/refresh-parent/parent/{parent}', [CourseController::class, 'refreshCodeParent'])
            ->name('refresh-parent');

        Route::post('/refresh-parent-with-child/parent/{parent}/course/{course}', [CourseController::class, 'refreshCodeParentWithChild'])
            ->name('refresh-parent-with-child');

        Route::post('/refresh-course/parent/{parent}/course/{course}', [CourseController::class, 'refreshCodeCourse'])
            ->name('refresh-course');

        Route::post('/delete-course-code/parent/{parent}/course/{course}/code/{code}', [CourseController::class, 'deleteCodeCourse'])
            ->name('delete-course-code');

        Route::post('/add-course-code/parent/{parent}/course/{course}', [CourseController::class, 'addCodeCourse'])
            ->name('add-course-code');

        Route::post('/disable-course/parent/{parent}/course/{course}', [CourseController::class, 'disableCourse'])
            ->name('disable-course');

        Route::post('/enable-course/parent/{parent}/course/{course}', [CourseController::class, 'enableCourse'])
            ->name('enable-course');

        Route::delete('/delete-course/parent/{parent}/course/{course}', [CourseController::class, 'deleteCourse'])
            ->name('delete-course');

        Route::post('/', [CourseController::class, 'upload'])
            ->name('upload');

        Route::post('/delete-course-file/parent/{parent}/course/{course}/file/{file}', [CourseController::class, 'deleteCourseFile'])
            ->name('delete-course-file');

        Route::post('/add-course-file', [CourseController::class, 'addCourseFile'])
            ->name('add-course-file');

        Route::post('/update-course-file', [CourseController::class, 'updateCourseFile'])
            ->name('update-course-file');

        Route::get('/download-parent-zip/{parent}', [CourseController::class, 'downloadParentZip'])
            ->name('download-parent-zip');
    });
