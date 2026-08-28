<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;

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


//đăng nhập mới thực hiện được
Route::middleware('auth')->group(function () {

Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // 1. Dòng GET: Dùng để HIỂN THỊ form 
    Route::get('/tao-don-hang', function () {
        return view('user.create-order');
    })->name('order.create');

    // 2. Dòng POST: Dùng để HỨNG DỮ LIỆU khi người dùng bấm nút "Đặt hàng"
    Route::post('/tao-don-hang', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');

    // 3. Route GET: Hiển thị giao diện Tạo đơn ký gửi
    Route::get('/tao-don-ky-gui', function () {
        return view('user.create-consignment'); // Đảm bảo bạn đã lưu file blade đúng tên này
    })->name('consignment.create');

    // 4. Route POST: Hứng dữ liệu khi bấm nút "Tạo đơn ký gửi"
    Route::post('/tao-don-ky-gui', [App\Http\Controllers\ConsignmentController::class, 'store'])->name('consignment.store');

    //5.tất cả đơn hàng
    Route::get('/danh-sach-don-hang', [App\Http\Controllers\OrderListController::class, 'index'])->name('list.order');

    //6. chi tiết đơn hàng
    Route::get('/don-mua-ho/chi-tiet/{id}', [App\Http\Controllers\OrderListController::class, 'show'])->name('order.show');

    // Mở form chỉnh sửa
Route::get('/don-mua-ho/sua/{id}', [App\Http\Controllers\OrderListController::class, 'edit'])->name('order.edit');

// Hứng dữ liệu khi submit form 
Route::put('/don-mua-ho/sua/{id}', [App\Http\Controllers\OrderListController::class, 'update'])->name('order.update');

Route::delete('/don-mua-ho/xoa/{id}', [App\Http\Controllers\OrderListController::class, 'destroy'])->name('order.destroy');

// Danh sách đơn ký gửi
Route::get('/danh-sach-don-ky-gui', [App\Http\Controllers\ConsignmentController::class, 'index'])->name('consignment.index');

//chi tiết đơn hàng ký gửi
Route::get('/don-ky-gui/chi-tiet/{id}', [App\Http\Controllers\ConsignmentController::class, 'show'])->name('consignment.show');

// Mở form sửa đơn ký gửi
Route::get('/don-ky-gui/sua/{id}', [App\Http\Controllers\ConsignmentController::class, 'edit'])->name('consignment.edit');

// Cập nhật dữ liệu đơn ký gửi
Route::put('/don-ky-gui/sua/{id}', [App\Http\Controllers\ConsignmentController::class, 'update'])->name('consignment.update');

// Xóa đơn ký gửi
Route::delete('/don-ky-gui/xoa/{id}', [App\Http\Controllers\ConsignmentController::class, 'destroy'])->name('consignment.destroy');

// danh sach kien hang
Route::get('/kien-hang', [App\Http\Controllers\PackageController::class, 'index'])->name('package.index');


// Giao diện Thêm kiện hàng
Route::get('/kien-hang/them', [App\Http\Controllers\PackageController::class, 'create'])->name('package.create');

// Xử lý lưu kiện hàng mới
Route::post('/kien-hang/them', [App\Http\Controllers\PackageController::class, 'store'])->name('package.store');

// Xem chi tiết kiện hàng
Route::get('/kien-hang/chi-tiet/{id}', [App\Http\Controllers\PackageController::class, 'show'])->name('package.show');

// Danh sách yêu cầu giao hàng
Route::get('/giao-hang', [App\Http\Controllers\DeliveryController::class, 'index'])->name('delivery.index');

// Danh sách kiện hàng ĐÃ GIAO
Route::get('/da-giao-hang', [App\Http\Controllers\DeliveryController::class, 'completed'])->name('delivery.completed');

// Danh sách Yêu cầu Kiểm hàng
Route::get('/kiem-hang', [App\Http\Controllers\PackageController::class, 'inspection'])->name('package.inspection');

//hướng dẫn nạp tiền
Route::get('/huong-dan-nap-tien', function () {
    return view('user.deposit-instructions');
})->name('deposit.instructions');

// Lịch sử giao dịch
Route::get('/lich-su-giao-dich', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');

// Yêu cầu rút tiền
Route::get('/rut-tien', [App\Http\Controllers\WithdrawalController::class, 'index'])->name('withdrawal.index');
Route::post('/rut-tien', [App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdrawal.store');

// Quản lý khiếu nại
Route::get('/khieu-nai', [App\Http\Controllers\ComplaintController::class, 'index'])->name('complaint.index');

// Tạo khiếu nại mới
Route::get('/khieu-nai/them', [App\Http\Controllers\ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/khieu-nai/them', [App\Http\Controllers\ComplaintController::class, 'store'])->name('complaint.store');

// Danh sách Hàng mất thông tin
Route::get('/hang-mat-thong-tin', [App\Http\Controllers\PackageController::class, 'lostPackages'])->name('package.lost');

// Danh sách Nhà cung cấp
Route::get('/nha-cung-cap', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');

// Thêm nhà cung cấp
Route::get('/nha-cung-cap/them', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
Route::post('/nha-cung-cap/them', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');


// Thông tin cá nhân
Route::get('/thong-tin-ca-nhan', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/thong-tin-ca-nhan', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');


// Quản lý Sổ địa chỉ giao hàng
Route::get('/dia-chi-giao-hang', [App\Http\Controllers\DeliveryAddressController::class, 'index'])->name('address.index');
Route::post('/dia-chi-giao-hang', [App\Http\Controllers\DeliveryAddressController::class, 'store'])->name('address.store');
Route::put('/dia-chi-giao-hang/{id}/mac-dinh', [App\Http\Controllers\DeliveryAddressController::class, 'setDefault'])->name('address.default');
Route::delete('/dia-chi-giao-hang/{id}', [App\Http\Controllers\DeliveryAddressController::class, 'destroy'])->name('address.destroy');

// Thay đổi mật khẩu
Route::get('/thay-doi-mat-khau', [App\Http\Controllers\ProfileController::class, 'editPassword'])->name('password.edit');
Route::put('/thay-doi-mat-khau', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');

// Hòm thư góp ý
Route::get('/hom-thu-gop-y', function () {
    return view('user.feedback');
})->name('feedback.index');

// Tất cả đơn hàng (Gộp Mua hộ + Ký gửi)
Route::get('/tat-ca-don-hang', [App\Http\Controllers\OrderController::class, 'allOrders'])->name('order.all');
});


// ================= ROUTE DÀNH CHO NHÂN VIÊN (ADMIN) =================
Route::prefix('admin')->group(function () {
    
    // Route chưa đăng nhập
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    // Route yêu cầu phải đăng nhập bằng tài khoản nhân viên
    Route::middleware(['auth:employee'])->group(function () {
        
        Route::get('/dashboard', function () {
            return "Chào mừng sếp " . Auth::guard('employee')->user()->ho_ten;
        })->name('admin.dashboard');

        // Thêm các route quản lý đơn hàng, khiếu nại... vào đây sau

    });
});