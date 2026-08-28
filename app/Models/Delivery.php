<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'package_id', 'ngay_tao', 'thong_tin_giao_hang', 'ma_buu_dien',
        'ma_van_don', 'ghi_chu', 'trang_thai', 'phuong_thuc_van_chuyen', 'phuong_thuc_thanh_toan'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}