<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Reviews extends Authenticatable
{
     protected $connection = 'mysql';
   protected $table = 'web_reviews';
}
