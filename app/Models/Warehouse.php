<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public $timestamps = false; 

    protected $fillable = [
        'ma_kho',
        'ten_kho',
        'loai_kho',
        'dia_chi',
    ];

    //  Quan hệ ngược lại: 1 Kho có nhiều Đơn mua hộ
    public function orders()
    {
        return $this->hasMany(Order::class, 'tru_so_nhan_hang_id');
    }

    //  Quan hệ ngược lại: 1 Kho có nhiều Đơn ký gửi
    public function consignmentOrders()
    {
        return $this->hasMany(ConsignmentOrder::class, 'kho_nhan_tq_id');
    }
}