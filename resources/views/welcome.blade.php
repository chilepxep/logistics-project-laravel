<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HTKK 360</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css'])
</head>

<body>

    <!-- header -->
    @include('layouts.header')
    <!-- banner -->
    @include('layouts.banner')

    <!-- quy trình -->
    @include('layouts.process')

    <!--cài đặt công cụ đặt hàng-->
    @include('layouts.tool');

    <!--service !-->
    @include('layouts.service');

    <!-- Bảng giá !-->
    @include('layouts.pricing')

    <!-- cam kết dịch vụ -->
    <section class="commitment-section position-relative pt-5">
        <div class="container position-relative z-2">
            <div class="row align-items-center">

                <!-- Cột trái: Ảnh nhân vật (bay từ dưới lên) -->
                <!-- Giả định bạn lưu ảnh người đàn ông là man-laptop.png -->
                <div class="col-12 col-md-5 text-center text-md-start reveal fade-up">
                    <img src="{{ asset('images/service.png') }}" class="img-fluid man-img" alt="Cam kết dịch vụ"
                        style="max-height: 380px;">
                </div>

                <!-- Cột phải: Nội dung cam kết (bay từ phải sang) -->
                <div class="col-12 col-md-7 text-white pb-5 reveal fade-right delay-1">
                    <h6 class="text-warning fw-bold mb-1">CAM KẾT</h6>
                    <h2 class="fw-bold text-uppercase mb-4">DỊCH VỤ</h2>
                    <p class="mb-4 text-light" style="font-size: 15px; line-height: 1.7; text-align: justify;">
                        Hệ thống phần mềm quản lý kho bãi, theo dõi đơn hàng minh bạch, rõ ràng. Chúng tôi cam kết mang
                        đến trải nghiệm nhập hàng Trung Quốc an toàn, nhanh chóng và tối ưu chi phí nhất cho mọi khách
                        hàng.
                    </p>

                    <div class="row g-4 mt-2">
                        <div class="col-12 col-sm-6">
                            <div class="d-flex">
                                <i class="bi bi-shield-check text-warning fs-3 me-3"></i>
                                <div>
                                    <h6 class="fw-bold text-warning mb-1">Thời gian vận chuyển</h6>
                                    <p class="text-light mb-0" style="font-size: 13px;">Hàng hóa lưu thông ổn định, tốc
                                        độ vận chuyển chỉ từ 2-5 ngày.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="d-flex">
                                <i class="bi bi-wallet2 text-warning fs-3 me-3"></i>
                                <div>
                                    <h6 class="fw-bold text-warning mb-1">Cước phí cạnh tranh</h6>
                                    <p class="text-light mb-0" style="font-size: 13px;">Bảng giá rõ ràng, cam kết không
                                        phát sinh bất kỳ phụ phí ngầm nào.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 6.2 Khối 4 ô thống kê nằm đè lên ranh giới (Overlap) -->
    <section class="stats-section position-relative z-3">
        <div class="container">
            <!-- Khung bo tròn chứa 4 ô, bay từ dưới lên -->
            <div class="row g-0 stats-container shadow-lg rounded-3 overflow-hidden reveal fade-up delay-2">

                <!-- Box 1 (Hồng/Đỏ) -->
                <div class="col-6 col-md-3">
                    <div class="stat-box text-white p-3 p-lg-4 d-flex align-items-center justify-content-center h-100"
                        style="background-color: #d80065;">
                        <h2 class="fw-bold mb-0 me-2">98<span class="fs-5">%</span></h2>
                        <span class="stat-text">Tỷ lệ đặt hàng<br>thành công</span>
                    </div>
                </div>

                <!-- Box 2 (Tím) -->
                <div class="col-6 col-md-3">
                    <div class="stat-box text-white p-3 p-lg-4 d-flex align-items-center justify-content-center h-100"
                        style="background-color: #6a1b9a;">
                        <h2 class="fw-bold mb-0 me-2">4,5<span class="fs-5">/5</span></h2>
                        <span class="stat-text">Điểm đánh giá<br>dịch vụ</span>
                    </div>
                </div>

                <!-- Box 3 (Xanh dương đậm) -->
                <div class="col-6 col-md-3">
                    <div class="stat-box text-white p-3 p-lg-4 d-flex align-items-center justify-content-center h-100"
                        style="background-color: #0277bd;">
                        <h2 class="fw-bold mb-0 me-2">96<span class="fs-5">%</span></h2>
                        <span class="stat-text">Khách hàng<br>quay lại</span>
                    </div>
                </div>

                <!-- Box 4 (Xanh dương nhạt) -->
                <div class="col-6 col-md-3">
                    <div class="stat-box text-white p-3 p-lg-4 d-flex align-items-center justify-content-center h-100"
                        style="background-color: #0288d1;">
                        <h2 class="fw-bold mb-0 me-2">48<span class="fs-5">h</span></h2>
                        <span class="stat-text">Thời gian giải quyết<br>khiếu nại</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!--form -->
    <section class="promo-register-section py-5 position-relative">
        <div class="container py-5">
            <div class="row align-items-center justify-content-center">

                <!-- Cột Trái: Ảnh Khuyến Mãi (Bay từ trái sang) -->
                <div class="col-12 col-md-6 text-center mb-5 mb-md-0 reveal fade-left">
                    <!-- Giả định ảnh khuyến mãi tên là promo-50k.png -->
                    <img src="{{ asset('images/sale.png') }}" class="img-fluid" alt="Tặng ngay 50k"
                        style="max-width: 90%;">
                </div>

                <!-- Cột Phải: Form Đăng Ký (Bay từ phải sang) -->
                <div class="col-12 col-md-5 reveal fade-right delay-1">
                    <div class="register-box p-4 p-md-5 rounded-4 shadow-lg text-center">

                        <!-- Tiêu đề Form -->
                        <h4 class="text-white fw-bold mb-2">ĐĂNG KÝ NHẬN ƯU ĐÃI</h4>
                        <p class="text-warning mb-4" style="font-size: 14px;">Để lại thông tin để nhận ngay khuyến mãi
                        </p>

                        <!-- Form của Laravel -->
                        <form action="#" method="POST">
                            <!-- @csrf là lệnh BẮT BUỘC của Laravel để bảo mật form -->
                            @csrf

                            <div class="mb-3">
                                <input type="text" name="name" class="form-control rounded-pill px-4 py-2 shadow-none"
                                    placeholder="Họ và tên (*)" required>
                            </div>

                            <div class="mb-3">
                                <input type="tel" name="phone" class="form-control rounded-pill px-4 py-2 shadow-none"
                                    placeholder="Số điện thoại (*)" required>
                            </div>

                            <div class="mb-4">
                                <input type="email" name="email" class="form-control rounded-pill px-4 py-2 shadow-none"
                                    placeholder="Email của bạn (Không bắt buộc)">
                            </div>

                            <!-- Nút Đăng ký (Tái sử dụng class hover-lift ở phần bảng giá) -->
                            <button type="submit" class="btn w-100 rounded-pill text-white fw-bold hover-lift py-2"
                                style="background-color: #ff6a00;">
                                ĐĂNG KÝ NGAY
                            </button>
                        </form>

                        <!-- Dòng cam kết bảo mật nhỏ ở dưới -->
                        <p class="text-light mt-3 mb-0" style="font-size: 12px; opacity: 0.8;">
                            <i class="bi bi-shield-lock me-1"></i> Cam kết bảo mật thông tin khách hàng tuyệt đối
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- GỌI FOOTER -->
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tìm tất cả các phần tử có class 'reveal'
        const reveals = document.querySelectorAll(".reveal");

        // Cấu hình bộ quan sát (Observer)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                // Nếu phần tử xuất hiện trong màn hình (khoảng 10%)
                if (entry.isIntersecting) {
                    entry.target.classList.add("active"); // Gắn class active để kích hoạt CSS
                    // observer.unobserve(entry.target); // Bỏ comment dòng này nếu bạn chỉ muốn hiệu ứng chạy 1 lần duy nhất
                } else {
                    // Xóa dòng này đi nếu không muốn hiệu ứng lặp lại khi cuộn lên cuộn xuống
                    entry.target.classList.remove("active");
                }
            });
        }, {
            threshold: 0.1 // 10% phần tử lọt vào khung hình là kích hoạt
        });

        // Bắt đầu quan sát từng phần tử
        reveals.forEach((reveal) => {
            observer.observe(reveal);
        });
    });
    </script>
</body>

</html>