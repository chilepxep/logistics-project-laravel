<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/index', function () {
    return view('welcome');
})->name('homepage');

Route::get('/dich-vu-kiem-dem', function () {
    return view('services/service-detail');
})->name('services.gia-tang');

Route::get('/dat-hang-trung-quoc', function () {
    return view('services/order-china');
})->name('services.dat-hang-trung-quoc');

Route::get('/van-chuyen-trung-quoc', function(){
    return view('services/ship-china');
})->name('services.van-chuyen-trung-quoc');

Route::get('danh-gia-hang', function(){
    return view('services/feedback-service');
})->name('services.danh-gia-hang');


Route::get('doi-tien-te', function(){
    return view('services/currency-conversion');
})->name('services.doi-tien-te');

Route::get('bang-gia-dich-vu', function() {
    return view('quotations/quotation-service');
})->name('quotations.bang-gia-dich-vu');

Route::get('bang-gia-ky-gui-hang', function() {
    return view('quotations/goods-consigment');
})->name('quotations.bang-gia-ky-gui-hang');

Route::get('bang-gia-hang-quang-chau', function() {
    return view('quotations/quotation-quangchau');
})->name('quotations.bang-gia-quang-chau');

Route::get('huong-dan-tao-don-hang', function() {
    return view('instructions/instruction-create-order');
})->name('instructions.huong-dan-tao-don-hang');


Route::get('huong-dan-tim-nguon-hang', function() {
    return view('instructions/instruction-search-items');
})->name('instructions.huong-dan-tim-nguon-hang');

Route::get('cong-cu-dat-hang', function() {
    return view('instructions/instruction-install-tool');
})->name('instructions.cong-cu-dat-hang');


Route::get('ky-gui-hang-trung-quoc', function() {
    return view('instructions/instruction-goods-consigment');
})->name('instructions.ky-gui-hang-trung-quoc');

Route::get('tra-cuoc', function() {
    return view('shipping-fee');
})->name('tra-cuoc');

Route::get('cau-hoi-thuong-gap', function() {
    return view('policy/questions');
})->name('policy.questions');

Route::get('chinh-sach-khieu-nai', function() {
    return view('policy/complaint-policy');
})->name('policy.chinh-sach-khieu-nai');

Route::get('quy-dinh-ve-ky-gui-hang', function() {
    return view('policy/goods-consigment-policy');
})->name('policy.quy-dinh-ve-ky-gui-hang');

Route::get('chinh-sach-bao-mat', function() {
    return view('policy/privacy-policy');
})->name('policy.chinh-sach-bao-mat');

Route::get('cap-nhat-chinh-sach', function() {
    return view('policy/update-policy');
})->name('policy.cap-nhat-chinh-sach');

Route::get('/tin-tuc', function() {
    return view('news');
})->name('tin-tuc');

Route::get('/su-kien', function() {
    return view('events');
})->name('su-kien');


Route::get('/tuyen-dung', function() {
    return view('recruitment');
})->name('tuyen-dung');

//khách vãng lai chưa đăng nhập
Route::middleware('guest')->group(function(){
    Route::get('/dang-ky', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/dang-ky',[AuthController::class, 'register']);

    Route::get('/dang-nhap', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/dang-nhap',[AuthController::class,'login']);
});

//đăng xuất
Route::post('/dang-xuat',[AuthController::class,'logout'])->name('logout')->middleware('auth');