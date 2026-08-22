<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappChat extends Model
{
    public $timestamps = false;

    protected $table = 'whatsapp_chats';

    protected $fillable = [
        'image_data',
        'caption',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
