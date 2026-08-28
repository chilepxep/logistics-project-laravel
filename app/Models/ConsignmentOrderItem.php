<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentOrderItem extends Model
{
   
    public $timestamps = false; 

    protected $fillable = [
        'consignment_order_id',
        'stt',
        'hinh_anh_url',
        'ma_van_don',
        'ten_san_pham',
        'so_kien_hang',
        'hang_van_chuyen',
        'tq_vn',
        'loai_danh_muc',
        'so_luong',
        'gia_tri_hang_hoa',
        'link_san_pham',
        'mo_ta_chi_tiet',
        'ghi_chu',
    ];
}