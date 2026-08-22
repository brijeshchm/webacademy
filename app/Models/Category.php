<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $table = 'web_categories';

    // protected $fillable = [
    //     'slug',
    //     'name',
    //     'tagline',
    //     'description',
    //     'icon_key',
    //     'course_count',
    //     'rating',
    //     'learners_enrolled',
    // ];
    
    protected $fillable = [
    'category',
    'category_slug',
    'video_link',
    'category_icons',
    'status',
    'created_by',
    'updated_by',
];

    // protected $casts = [
    //     'course_count'      => 'integer',
    //     'rating'            => 'float',
    //     'learners_enrolled' => 'integer',
    // ];
}
