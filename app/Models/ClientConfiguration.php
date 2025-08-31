<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'tiktok',
        'whatsapp',
        'telegram',
        'correo',

        'question',
        'answer',
        'explanation',

        'image_path',
        'image_name',
        'image_visible',
    ];

    protected $casts = [
        'image_visible' => 'boolean',
    ];
}
