<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'user_preferences';
    protected $fillable = [
        'user_id',
        'sources',
        'categories',
        'authors'
    ];
}
