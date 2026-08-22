<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public $timestamps = false;

    protected $table = 'web_testimonials';

    protected $fillable = [
        'name',
        'designation',
        'company_name',
        'total_rating',
        'rating',
        'avatar_url',
        'source',
        'status',
    ];

    
}
