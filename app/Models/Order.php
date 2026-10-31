<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
   protected $fillable = [
        'ma_don_hang', 'user_id', 'supplier_id', 'tru_so_nhan_hang_id', 
        'yeu_cau_toc_do', 'trang_thai', 'tong_tien','country_id', 'kho_hien_tai_id',
    ];

    // Quan hệ 1-Nhiều với Chi tiết đơn hàng
    public function items()
    {
       // return $this->hasMany(OrderItem::class);
       return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Quan hệ 1-Nhiều với Yêu cầu phát sinh
    public function extraRequirements()
    {
        return $this->hasMany(OrderExtraRequirement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

public function khoNhan()
{
    return $this->belongsTo(Warehouse::class, 'tru_so_nhan_hang_id');
}

public function country()
{
    return $this->belongsTo(Country::class, 'country_id');
}

public function khoHienTai()
{
    return $this->belongsTo(Warehouse::class, 'kho_hien_tai_id');
}

public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id');
}

public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'tru_so_nhan_hang_id');
    }


    public function packages()
{
    return $this->hasMany(Package::class, 'order_id'); 
}

    // 1. TỔNG TIỀN CƯỚC VẬN CHUYỂN
    public function getTongCuocVanChuyenAttribute()
    {
        return $this->packages()->sum('thanh_tien');
    }

    // 2. TỔNG THANH TOÁN (Tiền hàng + Tiền cước)
    public function getTongThanhToanAttribute()
    {
        // tong_tien là tiền mua sản phẩm, cộng thêm cước vận chuyển
        return $this->tong_tien + $this->tong_cuoc_van_chuyen;
    }
}