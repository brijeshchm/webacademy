<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proof extends Model
{
    public $timestamps = false;

    protected $table = 'proofs';

    protected $fillable = [
        'image_data',
        'caption',
        'proof_date',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
