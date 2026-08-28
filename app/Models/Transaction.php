<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false; 

    protected $fillable = [
        'user_id', 'thoi_gian', 'loai_giao_dich', 'thong_tin', 'gia_tri_giao_dich', 'so_du_hien_tai'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}