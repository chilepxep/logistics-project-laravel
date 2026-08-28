<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ConsignmentOrder extends Model
{
  protected $fillable = [
        'ma_don_ky_gui',
        'user_id',
        'ngay_tao_yeu_cau',
        'ngay_van_chuyen',
        'ngay_nhan_hang',
        'yeu_cau_toc_do',
        'kho_nhan_tq_id',
        'dia_chi_tra_hang',
        'so_kien',
        'trang_thai',
    ];

    public function items()
    {
        return $this->hasMany(ConsignmentOrderItem::class, 'consignment_order_id');
    }

    public function extraRequirements()
    {
        return $this->hasMany(ConsignmentExtraRequirement::class, 'consignment_order_id');
    }

    public function khoNhan()
    {
        return $this->belongsTo(Warehouse::class, 'kho_nhan_tq_id');
    }
}