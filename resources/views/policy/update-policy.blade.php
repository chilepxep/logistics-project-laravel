<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật chính sách - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
</head>

<body class="bg-light">

    <!-- HEADER -->
    @include('layouts.header')

    <!-- BREADCRUMB -->
    <div class="bg-white py-2 border-bottom mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Chính sách</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cập nhật chính sách</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- NỘI DUNG CHÍNH -->
    <section class="pb-5">
        <div class="container">
            <div class="row g-4">

                <!-- CỘT TRÁI: NỘI DUNG CHÍNH SÁCH (9 CỘT) -->
                <div class="col-12 col-lg-9">
                    <div class="bg-white p-4 p-md-5 border shadow-sm rounded">

                        <!-- Tiêu đề trang -->
                        <div class="text-center mb-5">
                            <h2 class="fw-bold text-uppercase" style="color: #0b3a68;">Cập nhật chính sách</h2>
                            <div class="mx-auto mt-2" style="height: 3px; width: 60px; background-color: #ff6a00;">
                            </div>
                        </div>



                        <!-- Mục 1 -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 d-flex align-items-center" style="color: #0b3a68;">
                                <i class="bi bi-1-circle-fill text-warning fs-4 me-2"></i> 1. CAM KẾT BÁO GIÁ & MUA HÀNG
                                TRONG 4 GIỜ
                            </h5>
                            <div class="text-dark ps-4" style="font-size: 15px; line-height: 1.7; text-align: justify;">
                                <p>Sau khi quý khách xuống đơn sẽ được báo giá trong tối đa 4h</p>
                                <p>Sau khi quý khách đặt cọc sẽ được đặt hàng trong 4h
                                </p>
                                <p class="mb-0">Trường hợp ngoài giờ làm việc hoặc nhà cung phản hồi chậm thì HTKK sẽ
                                    thông báo lại trong đơn đặt hàng của quý khách.</p>
                            </div>
                        </div>

                        <!-- Mục 2 -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 d-flex align-items-center" style="color: #0b3a68;">
                                <i class="bi bi-2-circle-fill text-warning fs-4 me-2"></i> CAM KẾT ĐÚNG GIÁ & ĐÚNG SẢN
                                PHẨM ĐẶT MUA
                            </h5>
                            <div class="text-dark ps-4" style="font-size: 15px; line-height: 1.7; text-align: justify;">
                                <p class="mb-0">Không báo tăng giá hàng hóa, dịch vụ vận chuyển nội địa nước ngoài</p>
                                <p class="mb-0">Đặt chuẩn quy cách sản phẩm khách hàng yêu cầu</p>
                                <p class="mb-0">Cam kết đền gấp 10 lần giá trị nếu khách hàng phát hiện nhân viên báo
                                    tăng giá hoặc không đặt đúng sản phẩm như đã yêu cầu.</p>
                                <p class="mb-0">Nếu sản phẩm phát sai do nhà cung cấp cần chụp lại màn hình đơn hàng để
                                    chứng minh.</p>

                            </div>
                        </div>




                        <hr class="my-5">

                        <!-- Mục 5: Khối CAM KẾT (Highlight đặc biệt) -->
                        <div class="p-4 mb-5 rounded-4" style="background-color: #f0f7ff; border: 1px solid #cce5ff;">
                            <h5 class="fw-bold mb-3 text-uppercase text-center" style="color: #0b3a68;">
                                <i class="bi bi-shield-lock-fill text-success fs-3 me-2 align-middle"></i> Cam kết bảo
                                mật thông tin
                            </h5>
                            <div class="text-dark" style="font-size: 14.5px; line-height: 1.7; text-align: justify;">
                                <p>Quý khách vui lòng khiếu nại khi gặp vấn đề trên tại tổng đài 024.66803049 hoặc trực
                                    tiếp trên hệ thống của HTKK!</p>
                                <p>Cảm ơn quý khách đã tin dùng dịch vụ của HTKK trong thời gian qua!</p>

                            </div>
                        </div>



                    </div>
                </div>

                <!-- CỘT PHẢI: SIDEBAR -->
                <div class="col-12 col-lg-3">
                    <div class="p-2 mb-3 text-white fw-bold text-uppercase rounded-top"
                        style="background-color: #0b3a68;">
                        <i class="bi bi-star-fill me-1 text-warning"></i> Dịch vụ hot
                    </div>

                    <div class="list-group list-group-flush border rounded overflow-hidden">
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <i class="bi bi-chevron-right me-1 text-warning"></i> Nạp tiền Alipay giá rẻ
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <i class="bi bi-chevron-right me-1 text-warning"></i> Ký gửi hàng hóa Trung - Việt
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <i class="bi bi-chevron-right me-1 text-warning"></i> Bảng giá mua hộ Taobao
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>