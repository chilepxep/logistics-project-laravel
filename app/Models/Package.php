<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_van_don', 'ma_don_kien_hang', 'order_id', 'consignment_order_id',
        'tinh_trang', 'ghi_chu', 'loai_hang', 'phi_van_chuyen_noi_dia',
        'tong_kg', 'tong_m3', 'phi_khac', 'chiet_khau', 'thanh_tien', 'tru_so_id'
    ];

    // Liên kết với Đơn mua hộ
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Liên kết với Đơn ký gửi
    public function consignmentOrder()
    {
        return $this->belongsTo(ConsignmentOrder::class, 'consignment_order_id');
    }

    // Liên kết với Kho nhận
    public function khoNhan()
    {
        return $this->belongsTo(Warehouse::class, 'tru_so_id');
    }

    // Liên kết với Giao hàng
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'package_id');
    }
}