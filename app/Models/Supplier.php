<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
   protected $fillable = [
    'ma_ncc', 'ten_ncc', 'country_id', 'thanh_pho', 'nganh_hang', 
    'hinh_thuc', 'logo_url', 'ten_nguoi_dai_dien', 'chuc_vu', 
    'chi_tiet', 'ten_ngan_hang', 'so_tai_khoan', 'chu_tai_khoan', 
    'chi_nhanh', 'tong_tien_dat_hang', 'tong_khieu_nai'
];

    // Một nhà cung cấp có nhiều phương thức liên hệ
    public function contacts()
    {
        return $this->hasMany(SupplierContact::class, 'supplier_id');
    }

    public function country()
{
    return $this->belongsTo(Country::class);
}
}