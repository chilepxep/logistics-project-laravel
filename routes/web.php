<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
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
    Route::post('/dang-ky',[AuthController::class, 'register'])->middleware('throttle:5,1');;

    Route::get('/dang-nhap', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/dang-nhap',[AuthController::class,'login'])->middleware('throttle:5,1');;
});

//đăng xuất
Route::post('/dang-xuat',[AuthController::class,'logout'])->name('logout')->middleware('auth');


//đăng nhập mới thực hiện được
Route::middleware('auth')->group(function () {

Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // 1. Dòng GET: Dùng để HIỂN THỊ form 
    // Route::get('/tao-don-hang', function () {
    //     return view('user.create-order');
    // })->name('order.create');
    Route::get('/tao-don-hang', [App\Http\Controllers\OrderController::class, 'create'])->name('order.create');

    // 2. Dòng POST: 
    Route::post('/tao-don-hang', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store')->middleware('throttle:5,1');;

    // 3. Route GET: Hiển thị giao diện Tạo đơn ký gửi
    Route::get('/tao-don-ky-gui', [App\Http\Controllers\ConsignmentController::class, 'create'])->name('consignment.create');

    // 4. Route POST: Hứng dữ liệu khi bấm nút "Tạo đơn ký gửi"
    Route::post('/tao-don-ky-gui', [App\Http\Controllers\ConsignmentController::class, 'store'])->name('consignment.store')->middleware('throttle:5,1');;

    //5.tất cả đơn hàng
    Route::get('/danh-sach-don-hang', [App\Http\Controllers\OrderListController::class, 'index'])->name('list.order');

    //6. chi tiết đơn hàng
    Route::get('/don-mua-ho/chi-tiet/{id}', [App\Http\Controllers\OrderListController::class, 'show'])->name('order.show');

    // Mở form chỉnh sửa
Route::get('/don-mua-ho/sua/{id}', [App\Http\Controllers\OrderListController::class, 'edit'])->name('order.edit');

// Hứng dữ liệu khi submit form 
Route::put('/don-mua-ho/sua/{id}', [App\Http\Controllers\OrderListController::class, 'update'])->name('order.update')->middleware('throttle:5,1');;

Route::delete('/don-mua-ho/xoa/{id}', [App\Http\Controllers\OrderListController::class, 'destroy'])->name('order.destroy');

// Danh sách đơn ký gửi
Route::get('/danh-sach-don-ky-gui', [App\Http\Controllers\ConsignmentController::class, 'index'])->name('consignment.index');

//chi tiết đơn hàng ký gửi
Route::get('/don-ky-gui/chi-tiet/{id}', [App\Http\Controllers\ConsignmentController::class, 'show'])->name('consignment.show');

// Mở form sửa đơn ký gửi
Route::get('/don-ky-gui/sua/{id}', [App\Http\Controllers\ConsignmentController::class, 'edit'])->name('consignment.edit');

// Cập nhật dữ liệu đơn ký gửi
Route::put('/don-ky-gui/sua/{id}', [App\Http\Controllers\ConsignmentController::class, 'update'])->name('consignment.update')->middleware('throttle:5,1');;

// Xóa đơn ký gửi
Route::delete('/don-ky-gui/xoa/{id}', [App\Http\Controllers\ConsignmentController::class, 'destroy'])->name('consignment.destroy');

// danh sach kien hang
Route::get('/kien-hang', [App\Http\Controllers\PackageController::class, 'index'])->name('package.index');


// Giao diện Thêm kiện hàng
Route::get('/kien-hang/them', [App\Http\Controllers\PackageController::class, 'create'])->name('package.create');

// Xử lý lưu kiện hàng mới
Route::post('/kien-hang/them', [App\Http\Controllers\PackageController::class, 'store'])->name('package.store')->middleware('throttle:5,1');;

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
Route::post('/rut-tien', [App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdrawal.store')->middleware('throttle:5,1');;

// Quản lý khiếu nại
Route::get('/khieu-nai', [App\Http\Controllers\ComplaintController::class, 'index'])->name('complaint.index');

// Tạo khiếu nại mới
Route::get('/khieu-nai/them', [App\Http\Controllers\ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/khieu-nai/them', [App\Http\Controllers\ComplaintController::class, 'store'])->name('complaint.store')->middleware('throttle:5,1');;

// Danh sách Hàng mất thông tin
Route::get('/hang-mat-thong-tin', [App\Http\Controllers\PackageController::class, 'lostPackages'])->name('package.lost');

// Danh sách Nhà cung cấp
Route::get('/nha-cung-cap', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');

// Thêm nhà cung cấp
Route::get('/nha-cung-cap/them', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
Route::post('/nha-cung-cap/them', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store')->middleware('throttle:5,1');;


// Thông tin cá nhân
Route::get('/thong-tin-ca-nhan', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/thong-tin-ca-nhan', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('throttle:5,1');;


// Quản lý Sổ địa chỉ giao hàng
Route::get('/dia-chi-giao-hang', [App\Http\Controllers\DeliveryAddressController::class, 'index'])->name('address.index');
Route::post('/dia-chi-giao-hang', [App\Http\Controllers\DeliveryAddressController::class, 'store'])->name('address.store')->middleware('throttle:5,1');;
Route::put('/dia-chi-giao-hang/{id}/mac-dinh', [App\Http\Controllers\DeliveryAddressController::class, 'setDefault'])->name('address.default')->middleware('throttle:5,1');;
Route::delete('/dia-chi-giao-hang/{id}', [App\Http\Controllers\DeliveryAddressController::class, 'destroy'])->name('address.destroy');

// Thay đổi mật khẩu
Route::get('/thay-doi-mat-khau', [App\Http\Controllers\ProfileController::class, 'editPassword'])->name('password.edit');
Route::put('/thay-doi-mat-khau', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update')->middleware('throttle:5,1');;

// Hòm thư góp ý
Route::get('/hom-thu-gop-y', function () {
    return view('user.feedback');
})->name('feedback.index');

// Tất cả đơn hàng (Gộp Mua hộ + Ký gửi)
Route::get('/tat-ca-don-hang', [App\Http\Controllers\OrderController::class, 'allOrders'])->name('order.all');
});


// Cụm Route Yêu cầu đăng nhập nhân viên
Route::prefix('admin')->group(function () {
    
    // Route chưa đăng nhập
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login')->middleware('throttle:30,1');;
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->middleware('throttle:30,1');;
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout')->middleware('throttle:30,1');;

    // Route yêu cầu phải đăng nhập bằng tài khoản nhân viên
    Route::middleware(['auth:employee'])->group(function () {
        
       // Trang tổng quan Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');


        // Quản lý Đơn mua hộ
Route::get('/don-mua-ho', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/don-mua-ho/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
Route::post('/don-mua-ho/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.update_status')->middleware('throttle:30,1');;


// Cập nhật toàn bộ đơn hàng (Sửa)
Route::get('/don-mua-ho/{id}/edit', [App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('admin.orders.edit');
Route::put('/don-mua-ho/{id}', [App\Http\Controllers\Admin\OrderController::class, 'update'])->name('admin.orders.update')->middleware('throttle:30,1');;

// Xoá đơn hàng
Route::delete('/don-mua-ho/{id}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.orders.destroy');
    });

    // Quản lý Đơn ký gửi
Route::get('/don-ky-gui', [App\Http\Controllers\Admin\ConsignmentOrderController::class, 'index'])->name('admin.consignment_orders.index');
Route::get('/don-ky-gui/{id}', [App\Http\Controllers\Admin\ConsignmentOrderController::class, 'show'])->name('admin.consignment_orders.show');
Route::get('/don-ky-gui/{id}/edit', [App\Http\Controllers\Admin\ConsignmentOrderController::class, 'edit'])->name('admin.consignment_orders.edit');
Route::put('/don-ky-gui/{id}', [App\Http\Controllers\Admin\ConsignmentOrderController::class, 'update'])->name('admin.consignment_orders.update')->middleware('throttle:30,1');;
Route::delete('/don-ky-gui/{id}', [App\Http\Controllers\Admin\ConsignmentOrderController::class, 'destroy'])->name('admin.consignment_orders.destroy');

// Quản lý Khách hàng
Route::get('/khach-hang', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
Route::get('/khach-hang/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show');
Route::get('/khach-hang/{id}/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('admin.customers.edit');
Route::put('/khach-hang/{id}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('admin.customers.update')->middleware('throttle:30,1');;
// Thêm Route Khoá/Mở khoá
Route::post('/khach-hang/{id}/toggle-lock', [App\Http\Controllers\Admin\CustomerController::class, 'toggleLock'])->name('admin.customers.lock')->middleware('throttle:30,1');;


// Quản lý Khiếu nại
Route::get('/khieu-nai', [App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('admin.complaints.index');
Route::get('/khieu-nai/{id}', [App\Http\Controllers\Admin\ComplaintController::class, 'show'])->name('admin.complaints.show');
Route::get('/khieu-nai/{id}/edit', [App\Http\Controllers\Admin\ComplaintController::class, 'edit'])->name('admin.complaints.edit');
Route::put('/khieu-nai/{id}', [App\Http\Controllers\Admin\ComplaintController::class, 'update'])->name('admin.complaints.update')->middleware('throttle:30,1');;
Route::delete('/khieu-nai/{id}', [App\Http\Controllers\Admin\ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');

// Quản lý Kiện hàng (Packages)
Route::get('/kien-hang', [App\Http\Controllers\Admin\PackageController::class, 'index'])->name('admin.packages.index');
Route::get('/kien-hang/{id}', [App\Http\Controllers\Admin\PackageController::class, 'show'])->name('admin.packages.show');
Route::get('/kien-hang/{id}/edit', [App\Http\Controllers\Admin\PackageController::class, 'edit'])->name('admin.packages.edit');
Route::put('/kien-hang/{id}', [App\Http\Controllers\Admin\PackageController::class, 'update'])->name('admin.packages.update')->middleware('throttle:30,1');;
Route::delete('/kien-hang/{id}', [App\Http\Controllers\Admin\PackageController::class, 'destroy'])->name('admin.packages.destroy');


// Quản lý Nhà cung cấp (Suppliers)
Route::get('/nha-cung-cap', [App\Http\Controllers\Admin\SupplierController::class, 'index'])->name('admin.suppliers.index');
Route::get('/nha-cung-cap/create', [App\Http\Controllers\Admin\SupplierController::class, 'create'])->name('admin.suppliers.create');
Route::get('/nha-cung-cap/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'show'])->name('admin.suppliers.show');
Route::post('/nha-cung-cap', [App\Http\Controllers\Admin\SupplierController::class, 'store'])->name('admin.suppliers.store')->middleware('throttle:30,1');;
Route::get('/nha-cung-cap/{id}/edit', [App\Http\Controllers\Admin\SupplierController::class, 'edit'])->name('admin.suppliers.edit');
Route::put('/nha-cung-cap/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'update'])->name('admin.suppliers.update')->middleware('throttle:30,1');;
Route::delete('/nha-cung-cap/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'destroy'])->name('admin.suppliers.destroy');

// Cụm Route CHỈ DÀNH CHO ADMIN QUẢN TRỊ
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/nhan-vien', [App\Http\Controllers\Admin\EmployeeController::class, 'index'])->name('admin.employees.index');
        Route::get('/nhan-vien/create', [App\Http\Controllers\Admin\EmployeeController::class, 'create'])->name('admin.employees.create');
        Route::post('/nhan-vien', [App\Http\Controllers\Admin\EmployeeController::class, 'store'])->name('admin.employees.store')->middleware('throttle:30,1');;
        Route::get('/nhan-vien/{id}/edit', [App\Http\Controllers\Admin\EmployeeController::class, 'edit'])->name('admin.employees.edit');
        Route::put('/nhan-vien/{id}', [App\Http\Controllers\Admin\EmployeeController::class, 'update'])->name('admin.employees.update')->middleware('throttle:30,1');;
        Route::delete('/nhan-vien/{id}', [App\Http\Controllers\Admin\EmployeeController::class, 'destroy'])->name('admin.employees.destroy');
    });
});