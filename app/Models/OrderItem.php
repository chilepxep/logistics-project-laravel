<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false; // Bảng này không có created_at, updated_at
    
    protected $fillable = [
        'order_id', 'stt', 'hinh_anh_url', 'ten_san_pham', 
        'mau_sac_kich_thuoc', 'link_san_pham', 'don_gia', 'so_luong', 'ghi_chu_khac'
    ];
}