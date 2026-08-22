<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoStory extends Model
{
    public $timestamps = false;

    protected $table = 'video_stories';

    protected $fillable = [
        'video_data',
        'label',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'created_at' => 'datetime',
    ];
}
