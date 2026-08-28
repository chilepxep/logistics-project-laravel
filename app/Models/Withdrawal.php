<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
   public $timestamps = false; 

    protected $fillable = [
        'user_id', 'so_tien', 'ngan_hang', 'thong_tin_chuyen_khoan', 
        'ngay_yeu_cau', 'ngay_rut', 'tinh_trang'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}