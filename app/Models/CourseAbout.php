<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CourseAbout extends Authenticatable
{
   protected $connection = 'mysql';
   protected $table = 'web_courseabout';
   protected $fillable = [
    'course_id',
    'courseabout',
    'heading',
    'paragraph1',
    'paragraph2',
    'paragraph3',
    'paragraph4',
    'paragraph5',
    'paragraph6',
    'heading1',
    'description1',
    'heading2',
    'description2',
    'heading3',
    'description3',
    'heading4',
    'description4',
    'heading5',
    'description5',
    'heading6',
    'description6',
];
}
