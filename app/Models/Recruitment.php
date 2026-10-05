<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'salary', 'location', 
        'deadline', 'description', 'requirements', 'is_active'
    ];


    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];
}