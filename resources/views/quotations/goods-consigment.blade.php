<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng giá vận chuyển - HTKK 360</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Bảng giá vận chuyển Trung Quốc - Việt Nam
                    </li>
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
                        Bảng giá vận chuyển Trung Quốc - Việt Nam
                    </div>

                    <div class="p-4">

                        <!-- ================================
                             BẢNG 1: CHI PHÍ MỘT ĐƠN HÀNG 
                             ================================ -->
                        <h5 class="fw-bold mb-3" style="color: #0b3a68;">1. CHI PHÍ MỘT ĐƠN HÀNG KÝ GỬI</h5>
                        <div class="table-responsive mb-3">
                            <!-- Sử dụng lại class custom-hover-table cực mượt -->
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Dịch vụ</th>
                                        <th style="width: 50%;">Giải thích</th>
                                        <th>Bắt buộc</th>
                                        <th>Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start fw-semibold">1. Phí vận chuyển Trung - Việt</td>
                                        <td class="text-start">Là chi phí để chuyển hàng từ kho của HTKK tại Trung Quốc
                                            về Việt Nam</td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">2. Phí ship Trung Quốc</td>
                                        <td class="text-start">Phí chuyển hàng từ nhà cung cấp tới kho của HTKK tại
                                            Trung Quốc</td>
                                        <td></td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">3. Phí kiểm đếm</td>
                                        <td class="text-start"> Dịch vụ đảm bảo sản phẩm của khách không bị nhà cung cấp
                                            giao sai hoặc thiếu</td>
                                        <td></td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">4. Phí đóng gỗ/td>
                                        <td class="text-start">Hình thức đảm bảo an toàn, hạn chế rủi ro đối với hàng dễ
                                            vỡ, dễ biến dạng</td>
                                        <td></td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">5. Phí bảo hiểm</td>
                                        <td class="text-start">Là dịch vụ đảm bảo hàng hóa cho khách và chịu trách nhiệm
                                            khi xảy ra rủi ro về hàng hóa và được áp dụng với những đơn hàng có mức giá
                                            từ 30 tệ/ 1 sản phẩm trở lên</td>
                                        <td></td>
                                        <td><i class="bi bi-check-lg text-success fs-5"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-semibold">6. Phí ship tận nhà</td>
                                        <td class="text-start">Là phí vận chuyển hàng từ kho của HTKK tại Việt Nam tới
                                            nhà của quý khách</td>
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
                        <h5 class="fw-bold mb-3" style="color: #0b3a68;">2. Phí vận chuyển quốc tế</h5>
                        <h6 style="color: #ff0a0a;" class="fw-bold mb-3">(Thay đổi bảng giá mới được áp dụng cho các
                            kiện hàng đến kho Trung Quốc từ ngày 14/03/2023)</h6>
                        <div class="table-responsive mb-5">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Trọng lượng (tính/kg)</th>
                                        <th>Hà Nội</th>
                                        <th>TP.HCM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>>100kg</td>
                                        <td>Liên hệ</td>
                                        <td>Liên hệ</td>
                                    </tr>
                                    <tr>
                                        <td>30->100kg</td>
                                        <td>29.000đ</td>
                                        <td>37.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>10->30kg</td>
                                        <td>30.000đ</td>
                                        <td>38.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>0->10kg</td>
                                        <td>31.000đ</td>
                                        <td>39.000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive mb-5">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th colspan="3">Trọng lượng (tính/kg)</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>>20m3</td>
                                        <td>Liên hệ</td>
                                        <td>Liên hệ</td>
                                    </tr>
                                    <tr>
                                        <td>10m3 -> 20m3</td>
                                        <td>3.400.000đ</td>
                                        <td>3.800.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>5m3 -> 10m3</td>
                                        <td>3.800.000đ</td>
                                        <td>4.200.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            < 5m3</td>
                                        <td>4.000.000đ</td>
                                        <td>4.400.000đ</td>
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
                             BẢNG 4.1: PHÍ VẬN CHUYỂN
                             ================================ -->
                        <h5 class="fw-bold mb-2" style="color: #0b3a68;">4. PHÍ VẬN CHUYỂN CHÍNH NGẠCH</h5>
                        <p class="text-danger fw-bold mb-3" style="font-size: 14px;">Thuế nhập khẩu (Nếu có) = % thuế x
                            Giá trị hàng hóa
                            Thuế VAT = 10% x Giá trị hàng hóa</p>

                        <div class="table-responsive mb-3">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Trọng lượng (Kg)</th>
                                        <th>Phí dịch vụ
                                            (Giá trị hàng hóa)</th>
                                        <th>Hà Nội</th>
                                        <th>Hồ Chí Minh</th>
                                        <th>Hải Phòng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            > 500kg</td>
                                        <td>0.5%</td>
                                        <td>Liên hệ</td>
                                        <td>Liên hệ</td>
                                        <td>Liên hệ</td>
                                    </tr>
                                    <tr>
                                        <td>> 200kg -> 500kg</td>
                                        <td>1%</td>
                                        <td>16.000đ</td>
                                        <td>11.000đ</td>
                                        <td>16.000đ</td>
                                    </tr>
                                    <tr>
                                        <td> 100kg -> 200kg</td>
                                        <td>1%</td>
                                        <td>10.000đ</td>
                                        <td>18.000đ</td>
                                        <td>13.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            < 30kg</td>
                                        <td>1%</td>
                                        <td>16.000đ</td>
                                        <td>24.000đ</td>
                                        <td> 19.000đ</td>
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

                        <h5 class="fw-bold mt-5 mb-3" style="color: #0b3a68;">Phí ship Trung Quốc</h5>
                        <div class="table-responsive mb-5">
                            <table class="table custom-hover-table align-middle">
                                <thead>
                                    <tr>
                                        <th colspan="1">LOẠI HÌNH</th>
                                        <th colspan="2">GIẢI THÍCH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Chuyển phát nhanh thông thường</td>
                                        <td>Kg đầu dựa vào quy định của nhà cung cấp trên trang Taobao hoặc Alibaba</td>
                                        <td>Kg tiếp theo nếu nhà cung cấp thuộc tỉnh Quảng Đông là 4 tệ, tỉnh khác là 8
                                            tệ</td>
                                    </tr>
                                    <tr>
                                        <td>Chuyển phát nhanh siêu tốc</td>
                                        <td>Kg đầu dựa vào quy định của nhà cung cấp trên trang Taobao hoặc Alibaba</td>
                                        <td>Mỗi 0.5kg tiếp theo là 5 tệ/kg</td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">Chuyển phát thường bằng oto tải</td>
                                        <td colspan="2">Mỗi kg 1 tệ/kg + 70 tệ/đơn hàng</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="border p-3 rounded"
                            style="background-color: #fff1f0; border-color: #ffa39e !important;">
                            <h6 class="fw-bold" style="color: #cf1322;">Quy định về dịch vụ hàng ký gửi từ Trung Quốc về
                                Việt Nam:</h6>
                            <h6 class="pb-2 font-size: 14px; fw-normal " style="color: #cf1322; ">HTKK Logistics nhận
                                vận chuyển
                                tất cả các mặt
                                hàng từ
                                Trung Quốc về
                                Việt Nam ngoài các sản phẩm sau đây:</h6>
                            <ul class="mb-0" style="color: #cf1322; font-size: 14px;">

                                <li>Các chất ma túy và chất kích thích thần kinh. Các loại bột.</li>
                                <li>Các mặt hàng thực phẩm chức năng ( nước hoa, đồ ăn, thuốc , dung dịch ... )</li>
                                <li>Vũ khí đạn dược, trang thiết bị kỹ thuật quân sự. ( súng , đao , kiếm , dao kéo....
                                    )</li>
                                <li>Các loại văn hóa phẩm đồi trụy, phản động, Vật phẩm, ấn phẩm, tài liệu nhằm phá hoại
                                    trật tự công cộng chống lại Nhà nước Cộng hòa Xã hội Chủ nghĩa Việt Nam.</li>
                                <li>Vật hoặc chất dễ nổ, dễ cháy và các chất gây nguy hiểm hoặc làm mất vệ sinh, gây ô
                                    nhiễm môi trường.</li>
                                <li>Các loại vật phẩm hàng hóa mà nhà nước cấm lưu thông, cấm kinh doanh, cấm xuất khẩu,
                                    nhập khẩu.</li>
                                <li>Sinh vật sống.</li>
                            </ul>
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