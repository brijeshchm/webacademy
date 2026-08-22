<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Blog extends Authenticatable
{
	
 
protected $fillable = [
    'title',
    'sub_title',
    'slug',
    'category',
    'subcategory',
    'blog_image',
    'image_banner',
    'rating',
    'total_rating',
    'meta_title',
    'meta_keywords',
    'meta_description',
    'blog_defination',
    'heading',
    'blog_about',
    'top_heading',
    'top_content',
    'bottom_heading',
    'bottom_content',
    'status',
    'faqq1',
    'faqa1',
	 'faqq2',
    'faqa2',
	
	 'faqq3',
    'faqa3',
	
	 'faqq4',
    'faqa4',
	
	
	 'faqq5',
    'faqa5',
	
	
    'created_by',
    'updated_by',
];


     protected $connection = 'mysql';
   protected $table = 'web_blog';
}
