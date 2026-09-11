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

    /**
     * Quan hệ với bảng Kho bãi (Warehouse)
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'tru_so_id');
    }

    /**
     * Quan hệ với bảng Đơn mua hộ (Order)
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Quan hệ với bảng Đơn ký gửi (ConsignmentOrder)
     */
    public function consignmentOrder()
    {
        return $this->belongsTo(ConsignmentOrder::class, 'consignment_order_id');
    }

    /**
     * Hàm ảo tự động dịch trạng thái và ghép tên kho (Đã làm ở bước trước)
     */
    public function getTrangThaiHienThiAttribute()
    {
        if ($this->tinh_trang == 'da_nhap_kho' && $this->warehouse) {
            return 'Đã nhập kho - ' . $this->warehouse->ten_kho;
        }
        
        $statusMap = [
            'cho_xu_ly' => 'Chờ xử lý',
            'xac_nhan_lai' => 'Cần xác nhận lại',
            'da_dat_hang' => 'Đã đặt hàng TQ',
            'dang_van_chuyen' => 'Đang luân chuyển',
            'dang_giao_hang' => 'Đang giao hàng',
            'hoan_thanh' => 'Hoàn thành',
            'da_huy' => 'Đã huỷ',
            'cho_cod' => 'Chờ thu COD',
        ];

        return $statusMap[$this->tinh_trang] ?? $this->tinh_trang;
    }
}