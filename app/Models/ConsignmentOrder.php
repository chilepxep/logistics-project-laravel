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
        'kho_hien_tai_id',
        'co_bao_hiem',  
        'co_khai_thue'  
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

    public function khoHienTai()
    {
        return $this->belongsTo(Warehouse::class, 'kho_hien_tai_id');
    }

    public function packages()
{

    return $this->hasMany(Package::class, 'consignment_order_id'); 
}

public function khoQuocTe()
    {
        return $this->belongsTo(Warehouse::class, 'supplier_id');
    }


    // 1. TỔNG TIỀN CƯỚC KHÁCH PHẢI TRẢ (Cộng dồn từ các kiện hàng)
    public function getTongCuocVanChuyenAttribute()
    {
        return $this->packages()->sum('thanh_tien');
    }

    // 2. TỔNG GIÁ TRỊ HÀNG HÓA (Dùng để đền bù)
    public function getTongGiaTriKhaiBaoAttribute()
    {
        // Giả sử bảng ConsignmentOrderItem có cột gia_tri_hang_hoa
        return $this->items()->sum('gia_tri_hang_hoa');
    }

    // 3. TÍNH TOÁN BỒI THƯỜNG DỰ KIẾN
    public function getMucBoiThuongAttribute()
    {
        $giaTri = $this->tong_gia_tri_khai_bao;
        if ($this->co_bao_hiem) {
            return $giaTri; // Đền 100% giá trị nếu có bảo hiểm
        }
        
        // Nếu không bảo hiểm, đền gấp 2
        $denBuTheoCuoc = $this->tong_cuoc_van_chuyen * 2;
        
        // Chọn mức đền bù thấp hơn giữa (2 lần cước) và (Giá trị thực)
        return min($denBuTheoCuoc, $giaTri); 
    }

    protected $casts = [
            'co_bao_hiem' => 'boolean',
            'co_khai_thue' => 'boolean',
    ];
}