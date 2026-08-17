<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ kiểm đếm - HTKK 360</title>
    <!-- Nhúng CSS của Bootstrap và Vite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
    @vite(['resources/css/ship-china.css'])
    @vite(['resources/css/order-china.css'])
</head>

<body>
    @include('layouts/header')
    <!-- 2. BREADCRUMB -->
    <div class="bg-light py-2 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vận chuyển Trung Quốc</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- 3. NỘI DUNG CHÍNH -->
    <section class="py-4 bg-white">
        <div class="container">
            <div class="row g-4">

                <!-- CỘT TRÁI: BÀI VIẾT & BẢNG GIÁ (9 CỘT) -->
                <div class="col-12 col-lg-9">

                    <!-- Tiêu đề trang -->
                    <div class="p-3 mb-4 text-white fw-bold text-uppercase rounded-top"
                        style="background-color: #0b3a68;">
                        <h4 class="mb-0 fs-5"><i class="bi bi-journal-text me-2"></i>Dịch vụ vận chuyển hàng từ Trung
                            Quốc về Việt Nam [Phí từ 8000VNĐ]</h4>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="article-body">

                        <p class="lead text-muted" style="font-size: 15px;">
                            Với kinh nghiệm hơn 10 năm hoạt động trong lĩnh vực vận chuyển hàng hóa từ Trung Quốc về
                            Việt Nam, HTKK luôn mang đến cho chủ shop, khách hàng những dịch vụ chuyên nghiệp. Nhờ đội
                            ngũ nhân viên giàu kinh nghiệm, năng lực vận chuyển lớn sẽ đảm bảo tốc độ và thời gian giao
                            hàng nhanh chóng trong 2 - 3 ngày với mức phí ký gửi siêu rẻ.
                        </p>

                        <div class="text-center my-4">
                            <img src="{{ asset('images/vanchuyentq.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                        </div>
                        <div class="service-content mb-5">

                            <h5 class="fw-bold mb-3">
                                Các loại chi phí khi vận chuyển hàng Trung Quốc về Việt Nam
                            </h5>

                            <ul class="mb-0">
                                <span class="fw-normal d-block mb-3">
                                    Trên thực tế, mỗi đơn hàng đặt mua từ các sàn TMĐT của Trung Quốc và vận chuyển về
                                    đến Việt Nam sẽ trải qua rất nhiều thủ tục và phải chi trả cho rất nhiều khoản chi
                                    phí khác nhau. Việc nắm rõ các mức phí này sẽ giúp các chủ shop dễ dàng hoạch định
                                    được kế hoạch kinh doanh của mình, đồng thời tránh phát sinh chi phí quá lớn khi
                                    nhập hàng kinh doanh. Hiện tại, với một đơn hàng vận chuyển Trung Quốc về đến Việt
                                    Nam, chủ shop sẽ phải chi trả cho những khoản phí sau đây.
                                </span>

                                <h5 class="fw-bold mb-3">
                                    Các khoản phí cố định
                                    <span class="fw-normal">
                                        (phí bắt buộc phải trả khi mua hàng Trung Quốc)
                                    </span>
                                </h5>
                                <li class="mb-3">
                                    <strong>Phí vận chuyển hàng từ Trung Quốc về Việt Nam:</strong>
                                    Mức phí giao hàng là bắt buộc và do đơn vị vận chuyển hàng Trung Quốc quy định. Chi
                                    phí cho một đơn hàng vận chuyển Trung Quốc về Việt Nam sẽ được tính theo trọng
                                    lượng, cân nặng hay khoảng cách vận chuyển theo đúng quy định của từng nhà cung cấp
                                    dịch vụ.
                                </li>

                                <li class="mb-3">
                                    <strong>Phí dịch vụ bảo hiểm hàng hóa:</strong>
                                    Sẽ do các đơn vị vận chuyển hàng Trung Việt quy định.
                                    Không phải đơn hàng nào cũng bắt buộc phải mua bảo hiểm.
                                </li>

                                <li>
                                    <strong>Phí giao hàng về tận nhà:</strong>
                                    Nếu muốn giao hàng tận nhà, khách hàng có thể liên hệ
                                    đơn vị vận chuyển để sử dụng dịch vụ.
                                </li>

                            </ul>

                        </div>

                        <div class="service-content mb-5">

                            <h5 class="fw-bold mb-3">
                                Phí tùy chọn
                                <span class="fw-normal">
                                    (Phí không bắt buộc phải chi trả)
                                </span>
                            </h5>

                            <ul class="mb-0">

                                <li class="mb-3">
                                    <strong>Phí kiểm đếm hàng hóa:</strong>
                                    Là dịch vụ do đơn vị vận chuyển hàng Trung Quốc áp dụng,
                                    các chủ shop chỉ phải chi trả chi phí này khi sử dụng thêm
                                    dịch vụ kiểm đếm hàng hóa.
                                </li>

                                <li class="mb-3">
                                    <strong>Chi phí đóng gói hàng hóa:</strong>
                                    Tương tự như dịch vụ kiểm đếm, chi phí này sẽ
                                    <strong>không bắt buộc</strong> mà chỉ có khách hàng nào
                                    sử dụng thêm dịch vụ đóng gói hàng hóa từ bên vận chuyển
                                    mới tính thêm phí này.
                                </li>

                                <li class="mb-3">
                                    <strong>Phí dịch vụ bảo hiểm hàng hóa:</strong>
                                    Sẽ do các đơn vị vận chuyển hàng Trung Việt quy định.
                                    Không phải đơn hàng nào cũng bắt buộc phải mua bảo hiểm.
                                </li>

                                <li>
                                    <strong>Phí giao hàng về tận nhà:</strong>
                                    Nếu muốn giao hàng tận nhà, khách hàng có thể liên hệ
                                    đơn vị vận chuyển để sử dụng dịch vụ.
                                </li>

                            </ul>

                        </div>
                        <!-- BẢNG 1: BẢNG GIÁ DỊCH VỤ MUA HỘ -->
                        <h5 class="fw-bold mt-4 mb-3" style="color: #0b3a68;">1. Bảng Phí Dịch Vụ Mua Hộ</h5>
                        <div class="table-responsive my-3">
                            <!-- Chỉ cần gọi class custom-hover-table là đủ, CSS sẽ tự căn giữa -->
                            <table class="table custom-hover-table">

                                <!-- Đã xóa style inline đi vì CSS đã xử lý -->
                                <thead>
                                    <tr>
                                        <th colspan="1">Thông tin</th>
                                        <th colspan="2">Chi tiết</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!-- Các thẻ <tr> và <td> của bạn giữ nguyên -->
                                    <tr>
                                        <td>Sản phẩm</td>
                                        <td>Số lượng</td>
                                        <td>Đơn giá</td>
                                    </tr>
                                    <tr>
                                        <td>Taobao</td>
                                        <td>10</td>
                                        <td>500 ¥</td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">Tổng cộng</td>
                                        <td colspan="2">5.000 ¥</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- BẢNG 2: CƯỚC VẬN CHUYỂN TRUNG - VIỆT -->
                        <h5 class="fw-bold mt-5 mb-3" style="color: #0b3a68;">2. Bảng Giá Vận Chuyển Trung Quốc - Việt
                            Nam</h5>
                        <div class="table-responsive my-3">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Mức cân nặng (Kg)</th>
                                        <th>Kho Hà Nội (VNĐ/Kg)</th>
                                        <th>Kho TP.HCM (VNĐ/Kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dưới 10 Kg</td>
                                        <td>28.000 đ</td>
                                        <td>33.000 đ</td>
                                    </tr>
                                    <tr>
                                        <td>10 Kg - 50 Kg</td>
                                        <td>25.000 đ</td>
                                        <td>30.000 đ</td>
                                    </tr>
                                    <tr>
                                        <td>50 Kg - 100 Kg</td>
                                        <td>22.000 đ</td>
                                        <td>27.000 đ</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-success">Trên 100 Kg</td>
                                        <td class="fw-bold text-danger">19.000 đ</td>
                                        <td class="fw-bold text-danger">24.000 đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- BẢNG 3: PHÍ KIỂM ĐẾM & ĐÓNG GỖ -->
                        <h5 class="fw-bold mt-5 mb-3" style="color: #0b3a68;">3. Phí Tùy Chọn Kèm Theo</h5>
                        <div class="table-responsive my-3">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Loại dịch vụ</th>
                                        <th>Mức phí tham khảo</th>
                                        <th>Mô tả</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">Kiểm đếm sản phẩm</td>
                                        <td>1.000 đ - 5.000 đ / SP</td>
                                        <td>Tránh giao sai màu, thiếu số lượng</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Đóng gỗ bảo vệ</td>
                                        <td>20 ¥ - 50 ¥ / kiện</td>
                                        <td>Khuyên dùng cho hàng dễ vỡ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- CỘT PHẢI: SIDEBAR (3 CỘT) -->
                <div class="col-12 col-lg-3">

                    <div class="custom-sidebar border bg-white shadow-sm p-4">

                        <!-- Nhóm 1: Đặt hàng -->
                        <div class="sidebar-group mb-4">
                            <h6 class="sidebar-heading text-uppercase">
                                <i class="bi bi-caret-right-fill"></i> Dịch vụ đặt hàng Trung Quốc
                            </h6>
                            <ul class="list-unstyled sidebar-list">
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Đặt hàng Quảng Châu</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Đặt Hàng TaoBao</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Đặt Hàng 1688</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Đặt hàng Alibaba</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Đặt hàng Tmall</a></li>
                            </ul>
                        </div>

                        <!-- Nhóm 2: Vận chuyển -->
                        <div class="sidebar-group mb-4">
                            <h6 class="sidebar-heading text-uppercase">
                                <i class="bi bi-caret-right-fill"></i> Vận chuyển hàng Trung Quốc
                            </h6>
                            <ul class="list-unstyled sidebar-list">
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển hàng Quảng Châu</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển đường bộ</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển đường hàng không</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển đường sắt</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển đường thuỷ</a></li>
                            </ul>
                        </div>

                        <!-- Nhóm 3: Ghép nhóm -->
                        <div class="sidebar-group">
                            <h6 class="sidebar-heading text-uppercase">
                                <i class="bi bi-caret-right-fill"></i> Ghép nhóm đánh hàng
                            </h6>
                            <ul class="list-unstyled sidebar-list">
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Phiên dịch, đặt vé tàu, máy
                                        bay...</a></li>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    @include('layouts/footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>