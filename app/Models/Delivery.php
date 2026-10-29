<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Delivery extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'package_id', 'ngay_tao', 'ngay_giao_xong', 'thong_tin_giao_hang', 'ma_buu_dien', 'ma_vung_noi_dia',
        'ma_van_don', 'ghi_chu', 'trang_thai', 'phuong_thuc_van_chuyen', 'phuong_thuc_thanh_toan'
    ];

    protected $appends = ['phu_phi_tre_han', 'so_ngay_tre'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function getSoNgayTreAttribute()
    {
        if (!$this->ngay_tao) return 0;

        // Ép về mốc 00:00:00 của ngày để tính toán khoảng cách ngày chính xác tuyệt đối
        $startDate = Carbon::parse($this->ngay_tao)->startOfDay();
        $endDate = $this->ngay_giao_xong ? Carbon::parse($this->ngay_giao_xong)->startOfDay() : Carbon::now()->startOfDay();

        $daysDiff = $startDate->diffInDays($endDate);

        // Miễn phí 3 ngày đầu
        $daysLate = $daysDiff - 3;

        return $daysLate > 0 ? $daysLate : 0;
    }

    // 2. Logic tính tiền (15.000đ/ngày)
    public function getPhuPhiTreHanAttribute()
    {
        return $this->so_ngay_tre * 15000;
    }
}