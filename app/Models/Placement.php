<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Placement extends Authenticatable
{
     protected $connection = 'mysql';
   protected $table = 'web_placements';

   protected $fillable = [
    'name',
    'email',
    'course',
    'coursename',
    'related_courses',
    'placement_image',
    'rating',
    'total_rating',
    'comment',
    'company_name',
    'designation',
    'salary_hike',
    'status',
    'created_by',
    'updated_by',
];
}
