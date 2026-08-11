<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    protected $fillable = [
        'bride_name',
        'groom_name',
        'wedding_date',
        'cover_image',
    ];

    protected $casts = [
        'wedding_date' => 'date',
    ];
}