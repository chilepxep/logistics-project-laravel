<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'hinh_anh_url', 'order_id', 'package_id', 'loai_khieu_nai', 
        'trang_thai', 'phuong_an', 'nhan_vien_dat_hang_id', 'nhan_vien_xu_ly_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}