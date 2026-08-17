<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Giá & Dịch Vụ Đặt Hàng Trung Quốc - HTKK 360</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Nhúng CSS qua Vite -->
    @vite(['resources/css/app.css'])
    @vite(['resources/css/order-china.css'])
</head>

<body>

    <!-- 1. HEADER -->
    @include('layouts.header')

    <!-- 2. BREADCRUMB -->
    <div class="bg-light py-2 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đặt hàng Trung Quốc</li>
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
                        <h4 class="mb-0 fs-5"><i class="bi bi-journal-text me-2"></i>Dịch Vụ & Bảng Giá Đặt Hàng Trung
                            Quốc</h4>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="article-body">

                        <p class="lead text-muted" style="font-size: 15px;">
                            Với kinh nghiệm hơn 10 năm hoạt động trong lĩnh vực vận chuyển hàng hóa từ Trung Quốc về
                            Việt Nam, HTKK luôn mang đến cho chủ shop, khách hàng những dịch vụ chuyên nghiệp. Nhờ đội
                            ngũ nhân viên giàu kinh nghiệm, năng lực vận chuyển lớn sẽ đảm bảo tốc độ và thời gian giao
                            hàng nhanh chóng trong 2 - 3 ngày với mức phí ký gửi siêu rẻ.
                        </p>
                        <div class="service-content mb-5">

                            <h5 class="fw-bold mb-3">
                                Các khoản phí cố định
                                <span class="fw-normal">
                                    (phí bắt buộc phải trả khi mua hàng Trung Quốc)
                                </span>
                            </h5>

                            <ul class="mb-0">

                                <li class="mb-3">
                                    <strong>Phí ship nội địa Trung Quốc:</strong>
                                    Phí giao hàng nội địa được tính theo khoảng cách từ nhà cung cấp đến kho hàng hoặc
                                    địa chỉ của chủ shop cung cấp. Đây là mức phí bắt buộc và do các sàn TMĐT hay nhà
                                    cung cấp quy định.
                                </li>

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
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Giá trị đơn hàng (NDT)</th>
                                        <th>Phí dịch vụ (%)</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">Dưới 2.000 ¥</td>
                                        <td class="text-danger fw-bold">3%</td>
                                        <td>Áp dụng cho đơn lẻ</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">2.000 ¥ - 10.000 ¥</td>
                                        <td class="text-danger fw-bold">2.5%</td>
                                        <td>Hỗ trợ thương lượng giá</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Trên 10.000 ¥</td>
                                        <td class="text-danger fw-bold">1.5%</td>
                                        <td>Ưu tiên xử lý nhanh</td>
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

    <!-- 4. FOOTER -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>