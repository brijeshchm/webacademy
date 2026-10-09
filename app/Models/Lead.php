<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public $timestamps = false;

    protected $table = 'web_enquiries';

    protected $fillable = [
    'category',
    'sub_category',
    'first_name',
    'middle_name',
    'last_name',
    'name',
    'from_name',
    'email',
    'skype_id',
    'mobile',
    'code',
    'whatsapp_no',
    'form',
    'technology',
    'experience',
    'about',
    'course',
    'exam_date_time',
    'degree',
    'branch',
    'college',
    'scholarship_exam',
    'trainer',
    'start_date',
    'end_date',
    'source',
    'proj_name',
    'teic',
    'ttk',
    'cccae',
    'ccsb',
    'ccpagtu',
    'pcefyp',
    'avg_rating',
    'time_slot',
    'comp_name',
    'pass_no',
    'country',
    'call_prefered_time',
    'demo_date_time',
    'participant',
    'city',
    'geo_city',
    'geo_latitude',
    'geo_longitude',
    'geo_country',
    'geo_ipaddress',
    'comment',
    'marked_as_read',
];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
