<?php
// app/Models/Area.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    
    protected $guarded = [];
    protected $fillable = [
        'id',
        'name',
        'image',
        'linkedin_url',
        'comment',
        'created_at',
        'updated_at',        
    ];
 
}