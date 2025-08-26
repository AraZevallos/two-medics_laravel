<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'is_enabled',
        'is_persistent',
        'expiration_date',
        'value',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
