<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Warehouse;
use App\Models\Country;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/suppliers-by-country/{country_id}', function($country_id) {
    // 1. Tìm thông tin Quốc gia dựa vào ID truyền lên
    $country = Country::find($country_id);

    if (!$country) {
        return response()->json([]); // Trả về mảng rỗng nếu không tìm thấy quốc gia
    }

    // 2. Lấy mã quốc gia (ví dụ: 'VN', 'CN', 'US')
    // Chú ý: Hãy thay đổi 'ma_quoc_gia' thành đúng tên cột lưu mã (VN, US...) trong bảng countries của bạn
    $maQuocGia = $country->ma_quoc_gia; 

    // 3. Truy vấn bảng Warehouse dùng mã quốc gia vừa lấy
    return Warehouse::where('loai_kho', $maQuocGia)
        ->get([
            'id', 
            'ten_kho as ten_ncc', // Đổi bí danh (alias) để JS cũ không bị lỗi (nếu JS đang dùng sup.ten_ncc)
            'dia_chi as thanh_pho', // Đổi bí danh tương tự cho địa chỉ
            'so_dien_thoai', 
            'ma_buu_dien', 
            'ghi_chu',
            'dia_chi',
            'ten_kho'
        ]);
});