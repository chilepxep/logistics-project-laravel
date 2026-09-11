<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
   protected $fillable = [
        'ma_don_hang', 'user_id', 'supplier_id', 'tru_so_nhan_hang_id', 
        'yeu_cau_toc_do', 'trang_thai', 'tong_tien','country_id'
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

public function supplier()
{
    return $this->belongsTo(Supplier::class, 'supplier_id');
}
}