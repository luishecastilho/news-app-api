<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $fillable = [
        'title',
        'banner',
        'description',
        'content',
        'source',
        'url',
        'category',
        'author',
        'publishedAt',
    ];

}
