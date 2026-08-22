<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CoursesMaster extends Authenticatable
{
     protected $connection = 'mysql';
   protected $table = 'web_coursemaster';
}
