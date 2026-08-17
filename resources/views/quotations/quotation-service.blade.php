<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ đổi tiền - HTKK 360</title>
    <!-- Nhúng CSS của Bootstrap và Vite -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
    @vite(['resources/css/ship-china.css'])
    @vite(['resources/css/order-china.css'])
</head>

<body>
    @include('layouts/header')
    <div class="bg-white py-2 border-bottom mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bảng giá dịch vụ đặt hàng Trung Quốc</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- NỘI DUNG CHÍNH -->
    <section class="pb-5">
        <div class="container">
            <div class="row g-4">

                <!-- CỘT TRÁI: NỘI DUNG CÁC BẢNG GIÁ (9 CỘT) -->
                <div class="col-12 col-lg-9 bg-white p-0 border shadow-sm">

                    <!-- Tiêu đề trang -->
                    <div class="p-3 text-white fw-bold text-uppercase" style="background-color: #0b3a68;">
                        BẢNG GIÁ DỊCH VỤ ĐẶT HÀNG TRUNG QUỐC
                    </div>

                    <div class="p-4">

                        <!-- ================================
                             BẢNG 1: CHI PHÍ MỘT ĐƠN HÀNG 
                             ================================ -->
                        <h5 class="fw-bold mb-3" style="color: #0b3a68;">1. CHI PHÍ MỘT ĐƠN HÀNG ORDER</h5>
                        <div class="table-responsive mb-3">
                            <!-- Sử dụng lại class custom-hover-table cực mượt -->
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Dịch vụ</th>
                                        <th style="width: 50%;">Ghi chú</th>
                                        <th>Bắt buộc</th>
                                        <th>Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start fw-semibold">1. Giá sản phẩm</td>
                                        <td class="text-start">Là giá được niêm yết trên website Trung Quốc</td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">2. Phí nội địa</td>
                                        <td class="text-start">Phí ship từ nhà cung cấp tới kho Trung Quốc</td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">3. Phí mua hàng</td>
                                        <td class="text-start">Phí dịch vụ giao dịch và thanh toán hộ</td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">4. Phí kiểm đếm</td>
                                        <td class="text-start">Đảm bảo đúng số lượng, màu sắc trước khi gửi về</td>
                                        <td></td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">5. Phí đóng gỗ</td>
                                        <td class="text-start">Giảm thiểu rủi ro móp méo, vỡ hỏng hàng hóa</td>
                                        <td></td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Hộp cảnh báo (Note box) màu hồng chữ đỏ -->
                        <div class="alert alert-danger border-0 rounded-0 p-3 mb-5"
                            style="background-color: #fff1f0; color: #cf1322; font-size: 14px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Lưu ý:</strong> Tiền cọc đơn
                            hàng sẽ bao gồm [Giá sản phẩm + Phí mua hàng]. Các khoản phí còn lại sẽ thanh toán khi hàng
                            về kho Việt Nam.
                        </div>

                        <!-- ================================
                             BẢNG 2: PHÍ DỊCH VỤ MUA HÀNG 
                             ================================ -->
                        <h5 class="fw-bold mb-3" style="color: #0b3a68;">2. BẢNG GIÁ DỊCH VỤ MUA HÀNG</h5>
                        <div class="table-responsive mb-5">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Giá trị đơn hàng (VNĐ)</th>
                                        <th>Phí dịch vụ (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dưới 50 triệu</td>
                                        <td>3%</td>
                                    </tr>
                                    <tr>
                                        <td>Từ 50 triệu - 100 triệu</td>
                                        <td>2%</td>
                                    </tr>
                                    <tr>
                                        <td>Trên 100 triệu</td>
                                        <td>1.5%</td>
                                    </tr>
                                    <tr style="background-color: #f8f9fa;">
                                        <td colspan="2" class="fst-italic text-muted">Phí mua hàng tối thiểu: 10.000 VNĐ
                                            / 1 đơn hàng</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- ================================
                             BẢNG 4.1: PHÍ VẬN CHUYỂN
                             ================================ -->
                        <h5 class="fw-bold mb-2" style="color: #0b3a68;">4. PHÍ VẬN CHUYỂN QUỐC TẾ</h5>
                        <p class="text-danger fw-bold mb-3" style="font-size: 14px;">(ÁP DỤNG TRỌNG LƯỢNG THỰC TẾ HOẶC
                            TRỌNG LƯỢNG QUY ĐỔI MỨC NÀO CAO HƠN SẼ TÍNH MỨC ĐÓ)</p>

                        <h6 class="fw-bold mb-3">4.1. Phí vận chuyển hàng thường</h6>
                        <div class="table-responsive mb-3">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Trọng lượng (Kg)</th>
                                        <th>Hà Nội</th>
                                        <th>TP HCM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            < 10 Kg</td>
                                        <td>25.000đ</td>
                                        <td>35.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>10 - 50 Kg</td>
                                        <td>22.000đ</td>
                                        <td>32.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>50 - 100 Kg</td>
                                        <td>18.000đ</td>
                                        <td>28.000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Box Lưu ý chi tiết -->
                        <div class="border p-3 rounded"
                            style="background-color: #fff1f0; border-color: #ffa39e !important;">
                            <h6 class="fw-bold" style="color: #cf1322;">Lưu ý:</h6>
                            <ul class="mb-0" style="color: #cf1322; font-size: 14px;">
                                <li>Phí vận chuyển được tính theo cân nặng thực tế.</li>
                                <li>Đối với hàng hóa cồng kềnh, cước sẽ được tính theo công thức quy đổi: (Dài x Rộng x
                                    Cao) / 6000.</li>
                                <li>Thời gian vận chuyển dự kiến từ 2-5 ngày về Hà Nội và 5-7 ngày về TPHCM.</li>
                            </ul>
                        </div>

                        <!-- ================================
                             BẢNG 5: Cấp độ thành viên
                             ================================ -->
                        <h5 class="fw-bold mt-5 mb-3" style="color: #0b3a68;">8. CẤP ĐỘ THÀNH VIÊN</h5>
                        <div class="table-responsive mb-5">
                            <table class="table custom-hover-table align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>Cấp độ</th>
                                        <th>Chi tiêu tích luỹ</th>
                                        <th>Chiết khấu cước Vận chuyển</th>
                                        <th>Chiết khấu phí Mua hàng</th>
                                        <th>Đặt cọc</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- VIP 1: 1 Sao -->
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-center text-warning fs-6">
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </td>
                                        <td>Dưới 50 triệu</td>
                                        <td>0%</td>
                                        <td>0%</td>
                                        <td>70%</td>
                                    </tr>

                                    <!-- VIP 2: 2 Sao -->
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-center text-warning fs-6 gap-1">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </td>
                                        <td>Từ 50 triệu - 200 triệu</td>
                                        <td>1%</td>
                                        <td>1%</td>
                                        <td>60%</td>
                                    </tr>

                                    <!-- VIP 3: 3 Sao -->
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-center text-warning fs-6 gap-1">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </td>
                                        <td>Từ 200 triệu - 500 triệu</td>
                                        <td>2%</td>
                                        <td>2%</td>
                                        <td>50%</td>
                                    </tr>

                                    <!-- VIP 4: 4 Sao -->
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-center text-warning fs-6 gap-1">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </td>
                                        <td>Từ 500 triệu - 1 tỷ</td>
                                        <td>3%</td>
                                        <td>3%</td>
                                        <td>40%</td>
                                    </tr>

                                    <!-- VIP 5: 5 Sao -->
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-center text-warning fs-6 gap-1">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </td>
                                        <td>Từ 1 tỷ - 2 tỷ</td>
                                        <td>4%</td>
                                        <td>4%</td>
                                        <td>30%</td>
                                    </tr>

                                    <!-- VIP 6: 6 Sao -->
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-center text-warning fs-6 gap-1">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </td>
                                        <td>Trên 2 tỷ</td>
                                        <td>5%</td>
                                        <td>5%</td>
                                        <td>30%</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>



                <!-- CỘT PHẢI: SIDEBAR (3 CỘT) -->
                <!-- Sử dụng lại sidebar đã tạo ở bước trước -->
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
    @include('layouts/footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>