<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Warehouse;
use App\Models\Country;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/suppliers-by-country/{country_id}', function($country_id) {
    $country = Country::find($country_id);

    if (!$country) {
        return response()->json([]); 
    }
    $maQuocGia = $country->ma_quoc_gia; 
    return Warehouse::where('loai_kho', $maQuocGia)
        ->get([
            'id', 
            'ten_kho as ten_ncc',
            'dia_chi as thanh_pho', 
            'so_dien_thoai', 
            'ma_buu_dien', 
            'ghi_chu',
            'dia_chi',
            'ten_kho'
        ]);
});

Route::get('/get-suppliers-mua-ho/{country_id}', function($country_id) {
    $suppliers = \App\Models\Supplier::where('country_id', $country_id)->get([
        'id', 
        'ten_ncc',
        'ten_nguoi_dai_dien',
        'thanh_pho',
        'chi_tiet'
    ]);

    return response()->json($suppliers);
});

// Các API không cần đăng nhập
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Các API YÊU CẦU PHẢI ĐĂNG NHẬP (Gửi kèm Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Sau này bạn sẽ viết thêm API lấy danh sách kho, kiện hàng ở đây...
    // Route::get('/user/packages', ...);
});