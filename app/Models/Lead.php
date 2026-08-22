<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public $timestamps = false;

    protected $table = 'leads';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'course_slug',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
