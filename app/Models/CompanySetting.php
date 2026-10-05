<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
   protected $fillable = ['hotline', 'email', 'zalo_link', 'facebook_link', 'addresses'];

    
    protected $casts = [
        'addresses' => 'array', 
    ];
}