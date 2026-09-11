<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ConsignmentOrder extends Model
{
  protected $fillable = [
        'ma_don_ky_gui',
        'user_id',
        'chieu_van_chuyen',
        'kho_vn_id',        
        'country_id', 
        'supplier_id',
        'ngay_tao_yeu_cau',
        'ngay_van_chuyen',
        'ngay_nhan_hang',
        'yeu_cau_toc_do',
        'dia_chi_tra_hang',
        'so_kien',
        'trang_thai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(ConsignmentOrderItem::class, 'consignment_order_id');
    }

    public function extraRequirements()
    {
        return $this->hasMany(ConsignmentExtraRequirement::class, 'consignment_order_id');
    }

    public function khoVn()
    {
        return $this->belongsTo(Warehouse::class,  'kho_vn_id');
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