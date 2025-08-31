<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Course;
use App\Models\CourseFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use ZipArchive;

class CourseController extends Controller
{
    public $parents;

    public function __construct()
    {
        $this->parents = Course::whereNull('parent_id')->get();
    }

    public function index()
    {
        $countParents = Course::whereNull('parent_id')->count();
        $countCourses = Course::whereNotNull('parent_id')->count();
        $countVisibles = Course::whereNotNull('parent_id')->where('is_visible', true)->count();

        return Inertia::render('courses/Courses', [
            'parents' => $this->parents,
            'summary' => [
                'parents' => $countParents,
                'courses' => $countCourses,
                'visibles' => $countVisibles,
            ]
        ]);
    }

    public function parent(Course $parent)
    {
        $parent->load([
            'codes',
            'children' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ]);

        return Inertia::render('courses/Courses', [
            'parents' => $this->parents,
            'selectedParent' => $parent,
        ]);
    }

    public function course(Course $parent, Course $course)
    {
        $parent->load([
            'codes',
            'children' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ]);
        $course->load(['codes', 'files']);

        return Inertia::render('courses/Courses', [
            'parents' => $this->parents,
            'selectedParent' => $parent,
            'selectedCourse' => $course,
        ]);
    }

    public function refreshCodeParent(Course $parent)
    {
        $code = $parent->codes()->where('is_persistent', true)->first();

        if ($code) $code->update(['value' => randomfnWithYear()]);

        $parent->load([
            'codes',
            'children' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ]);

        return Inertia::render('courses/Courses', [
            'parents' => $this->parents,
            'selectedParent' => $parent,
        ]);
    }

    public function refreshCodeParentWithChild(Course $parent, Course $course)
    {
        $code = $parent->codes()->where('is_persistent', true)->first();

        if ($code) $code->update(['value' => randomfnWithYear()]);

        $parent->load([
            'codes',
            'children' => function ($query) {
                $query->orderBy('name', 'asc');
            },
        ]);
        if ($course) $course->load(['codes', 'files']);

        Log::info('course', [
            'course' => $course,
        ]);

        return Inertia::render('courses/Courses', [
            'parents' => $this->parents,
            'selectedParent' => $parent,
            'selectedCourse' => $course,
        ]);
    }

    public function refreshCodeCourse(Course $parent, Course $course)
    {
        $code = $course->codes()->where('is_persistent', true)->first();

        if ($code) $code->update(['value' => randomfnWithYear()]);

        return $this->course($parent, $course);
    }

    public function deleteCodeCourse(Course $parent, Course $course, Code $code)
    {
        $code->delete();

        return $this->course($parent, $course);
    }

    public function addCodeCourse(Course $parent, Course $course)
    {
        Code::create([
            'course_id' => $course->id,
            'is_enabled' => true,
            'is_persistent' => false,
            'expiration_date' => null,
            'value' => randomfnWithYear(),
        ]);

        return $this->course($parent, $course);
    }

    public function disableCourse(Course $parent, Course $course)
    {
        $course->update(['is_visible' => false]);

        return $this->course($parent, $course);
    }

    public function enableCourse(Course $parent, Course $course)
    {
        $course->update(['is_visible' => true]);

        return $this->course($parent, $course);
    }

    public function deleteCourse(Course $parent, Course $course)
    {
        $pdfs = CourseFile::where('course_id', $course->id)->get();

        foreach ($pdfs as $pdf) Storage::disk('r2')->delete($pdf->file_path);

        $course->delete();

        return $this->parent($parent);
    }

    public function upload(Request $request)
    {
        $key = $request->file('pdf')->store('courses', 'r2');
        // Storage::disk('r2')->url($key);

        $courseId = Course::create([
            'name' => $request->input('name'),
            'is_visible' => true,
            'parent_id' => $request->input('parent'),
        ])->id;

        CourseFile::create([
            'course_id' => $courseId,
            'file_name' => $request->file('pdf')->getClientOriginalName(),
            'file_type' => $request->file('pdf')->getClientOriginalExtension(),
            'file_path' => $key,
        ]);

        Code::create([
            'course_id' => $courseId,
            'is_enabled' => true,
            'is_persistent' => true,
            'expiration_date' => null,
            'value' => randomfnWithYear(),
        ]);

        Code::create([
            'course_id' => $courseId,
            'is_enabled' => true,
            'is_persistent' => false,
            'expiration_date' => null,
            'value' => randomfnWithYear(),
        ]);

        Code::create([
            'course_id' => $courseId,
            'is_enabled' => true,
            'is_persistent' => false,
            'expiration_date' => null,
            'value' => randomfnWithYear(),
        ]);

        $selectedParent = null;
        $selectedCourse = null;

        if ($request->has('parent'))
            $selectedParent = Course::with(
                ['codes', 'children' => function ($query) {
                    $query->orderBy('name', 'asc');
                }]
            )->find($request->parent);

        if ($request->has('course')) $selectedCourse = Course::with(['codes', 'files'])->find($request->course);

        return Inertia::render('courses/Courses', [
            'parents' => $this->parents,
            'selectedParent' => $selectedParent,
            'selectedCourse' => $selectedCourse,
        ]);
    }

    public function deleteCourseFile(Course $parent, Course $course, CourseFile $file)
    {
        Storage::disk('r2')->delete($file->file_path);
        $file->delete();

        return $this->course($parent, $course);
    }

    public function addCourseFile(Request $request)
    {
        $file = request()->file('pdf');

        $key = $file->store('courses', 'r2');

        CourseFile::create([
            'course_id' => $request->input('course'),
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_path' => $key,
        ]);

        $parent = Course::find($request->input('parent'));
        $course = Course::find($request->input('course'));

        return $this->course($parent, $course);
    }

    public function updateCourseFile(Request $request)
    {
        $fileDB = CourseFile::find($request->input('file'));

        $newFile = request()->file('pdf');

        $key = $newFile->store('courses', 'r2');

        Storage::disk('r2')->delete($fileDB->file_path);

        CourseFile::where('id', $fileDB->id)->update([
            'file_name' => $newFile->getClientOriginalName(),
            'file_type' => $newFile->getClientOriginalExtension(),
            'file_path' => $key,
        ]);

        $parent = Course::find($request->input('parent'));
        $course = Course::find($request->input('course'));

        return $this->course($parent, $course);
    }

    public function downloadParentZip($parentId)
    {
        $parent = Course::with('children.files')->findOrFail($parentId);

        $zipFileName = $parent->name . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($parent->children as $course) {
                if ($course->is_visible) {
                    foreach ($course->files as $file) {
                        $fileContent = Storage::disk('r2')->get($file->file_path);

                        if ($fileContent !== false) {
                            $zip->addFromString($course->name . '/' . basename($file->file_name), $fileContent);
                        }
                    }
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}

function randomfnWithYear($length = 6)
{
    $pool = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $random = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);

    return strtolower($random . date('y'));
}
