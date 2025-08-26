<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseFile extends Model
{
    protected $fillable = [
        'course_id',
        'file_name',
        'file_type',
        'file_path',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
