<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'is_visible',
        'parent_id',
    ];

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function children()
    {
        return $this->hasMany(Course::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Course::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(CourseFile::class, 'course_id');
    }
}
