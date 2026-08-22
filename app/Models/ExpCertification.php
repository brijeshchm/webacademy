<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ExpCertification extends Authenticatable
{
     protected $connection = 'mysql1';
   protected $table = 'certificates';
}
