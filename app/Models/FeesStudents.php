<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FeesStudents extends Authenticatable
{
     protected $connection = 'mysql1';
   protected $table = 'wp_students_details';
}
