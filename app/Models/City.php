<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class City extends Authenticatable
{
     protected $connection = 'mysql';
   protected $table = 'web_city';
}
