<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hướng dẫn cài đặt công cụ - HTKK 360</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Hướng dẫn cài đặt công cụ
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
                        <h4 class="mb-0 fs-5"><i class="bi bi-journal-text me-2"></i>Hướng dẫn cài đặt công cụ đặt </h4>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="article-body">

                        <div class="toc-box border p-3 mb-4 rounded bg-light" style="max-width: 400px;">
                            <p class="fw-bold mb-2">Mục lục</p>
                            <ul class="list-unstyled mb-0" style="font-size: 14px;">
                                <li class="mb-1">
                                    <a href="#muc-1" class="text-decoration-none" style="color: #0b3a68;"> 1 Lý do nên
                                        cài đặt công cụ đặt hàng của HTKK? </a>
                                </li>
                                <ul class="list-unstyled ms-3 mt-1">
                                    <li class="mb-1">
                                        <a href="#muc-1-1" class="text-decoration-none" style="color: #555;">
                                            1.1 Giỏ hàng xem trước
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="#muc-1-2" class="text-decoration-none" style="color: #555;">
                                            1.2 Tỷ giá và chuyển đổi
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="#muc-1-2" class="text-decoration-none" style="color: #555;">
                                            1.3 Cập nhật thông tin đầy đủ, chính xác về sản phẩm
                                        </a>
                                    </li>
                                </ul>
                                <li class="mb-1"><a href="#muc-2" class="text-decoration-none" style="color: #0b3a68;">2
                                        Tính năng chính của công cụ đặt hàng</a></li>
                                <li class="mb-1"><a href="#muc-2" class="text-decoration-none" style="color: #0b3a68;">3
                                        Hướng dẫn cách cài đặt công cụ đặt hàng Taobao, Tmall, 1688 của HTKK</a></li>
                            </ul>
                        </div>


                        <div class="service-content mb-5">

                            <h5 class="fw-bold mb-3">
                                Lý do nên cài đặt công cụ đặt hàng của HTKK?
                            </h5>


                            <span class="fw-normal d-block mb-3">
                                Trên thực tế, việc nhập hàng Trung Quốc từ các trang thương mại Taobao, Tmall, 1688
                                không còn quá xa lạ với người tiêu dùng và các tiểu thương ở Việt Nam. Nhưng có lẽ
                                điều gây cản trở lớn nhất khi mua hàng trên các trang TMĐT này là rào cản về ngôn
                                ngữ khiến cho việc đặt hàng và thương lượng giá cả trở nên khó khăn hơn. Xuất phát
                                từ nhu cầu thực tế đó, công cụ đặt hàng HTKK Logistics ra đời, nhằm giải quyết tất
                                cả những vướng mắc mà khách hàng đang gặp phải như:
                            </span>


                            <ul class="mb-0">
                                <li class="mb-3">

                                    Lên đơn hàng và đặt hàng trực tiếp với nhà cung cấp từ Trung Quốc.
                                </li>

                                <li class="mb-3">

                                    Hỗ trợ phiên dịch tiếng Việt – Trung trong quá trình mua hàng, thương lượng và thanh
                                    toán.
                                </li>

                                <li class="mb-3">

                                    Chuyển đơn hàng sang hệ thống của HTKK giúp quá trình theo dõi và quản lý đơn hàng
                                    thuận tiện hơn.
                                </li>
                            </ul>



                            <div class=" my-4">
                                <img src="{{ asset('images/congcudathang1.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                            </div>


                            <p class="mb-3 fst-italic">
                                Công cụ đặt hàng HTKK giúp việc quản lý và theo dõi đơn hàng thuận tiện hơn
                            </p>

                            <h5 class="fw-bold mb-3">
                                Tính năng chính của công cụ đặt hàng
                            </h5>

                            <p class="mb-3 fw-bold">
                                Giỏ hàng xem trước
                            </p>

                            <span class="fw-normal d-block mb-3">
                                Mỗi khi đặt hàng người dùng cần xem trước những sản phẩm mà mình định mua mà không
                                cần đăng nhập tài khoản hay chưa. Thông qua công cụ này, sẽ tự động lưu giữ lại tất
                                cả cho đến khi bạn lựa chọn mục “xóa tất cả” trong phần giỏ hàng.
                            </span>

                            <p class="mb-3 fw-bold">
                                Tỷ giá và chuyển đổi
                            </p>

                            <span class="fw-normal d-block mb-3">
                                Công cụ đặt hàng của HTKK sẽ tự động cập nhật tỷ giá quy đổi tiền tệ theo thời gian
                                thực. Từ đó, sẽ đưa ra được giá trị chính xác nhất của sản phẩm thông qua việc quy
                                đổi tiền Tệ sang tiền Việt.

                                Công cụ đặt hàng của HTKK sẽ cập nhật tỷ giá theo thời gian thực và dựa vào giá trị
                                này để quy đổi hàng hóa từ tiền Tệ sang tiền Việt một cách dễ dàng. Từ đó, khách
                                hàng sẽ dễ dàng theo dõi giá trị sản phẩm một cách chính xác nhất.
                            </span>

                            <p class="mb-3 fw-bold">
                                Cập nhật thông tin đầy đủ, chính xác về sản phẩm
                            </p>

                            <span class="fw-normal d-block mb-3">
                                Khi người dùng xem bất cứ một mặt hàng nào, công cụ đặt hàng sẽ tự động cập nhật các
                                dữ liệu trên Taobao, Tmall, 1688 về màu sắc, kích thước mà bạn chọn. Từ đó, sẽ tự
                                động cập nhật lại giá trị chính xác về sản phẩm. Bên cạnh đó, việc tạo ra đơn hàng
                                tự động cũng giúp người dùng giảm thiểu được thời gian đặt hàng tối đa, vì đã biết
                                được chính xác thông tin về sản phẩm mà mình định mua.
                            </span>


                            <h5 class="fw-bold mb-3">
                                Hướng dẫn cách cài đặt công cụ đặt hàng Taobao, Tmall, 1688 của HTKK
                            </h5>

                            <span class="fw-normal d-block mb-3">
                                Với những khách hàng muốn cài đặt công cụ đặt hàng HTKK, bạn thực hiện theo hướng
                                dẫn sau đây.
                            </span>

                            <li class="mb-3">
                                <strong>Bước 1:</strong>
                                Tải tiện ích tiện ích về máy tính.
                            </li>

                            <span class="fw-normal d-block mb-3">
                                Để cài đặt công cụ đặt hàng HTKK bạn truy cập vào link sau:
                                <a href="https://bit.ly/2RJb0GM"> https://bit.ly/2RJb0GM</a>
                            </span>

                            <div class=" my-4">
                                <img src="{{ asset('images/congcudathang2.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                            </div>
                            <p class="mb-3 fst-italic">
                                Giao diện công cụ đặt hàng của HTKK
                            </p>

                            <li class="mb-3">
                                <strong>Bước 2:</strong>
                                Bạn ấn vào Thêm vào Chrome
                            </li>
                            <div class=" my-4">
                                <img src="{{ asset('images/congcudathang3.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                            </div>
                            <p class="mb-3 fst-italic">
                                Lúc này, bạn bấm chọn "Thêm vào Chrome" và tiếp tục chọn "Add extension" (Thêm tiện
                                ích).
                            </p>


                            <li class="mb-3">
                                <strong>Bước 3:</strong>
                                Bạn nhấp vào Thêm tiện ích.
                            </li>
                            <div class=" my-4">
                                <img src="{{ asset('images/congcudathang4.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                            </div>
                            <p class="mb-3 fst-italic">
                                Sau khi cài đặt công cụ đặt hàng, hệ thống đồng thời sẽ thông báo đã cài đặt thành
                                công. Giờ đây bạn hoàn toàn có thể sử dụng công cụ đặt hàng để mua hàng trên các
                                trang TMĐT Taobao, Tmall, 1688 rồi.
                            </p>
                            <p class="mb-3 fst-italic">
                                Như vậy là bạn đã cài đặt xong công cụ/tiện ích đặt hàng của HTKK. Với công cụ đặt
                                hàng này, việc nhập hàng Trung Quốc, order Taobao, order 1688, Tmall... sẽ trở lên
                                vô cùng dễ dàng. Chúc bạn thành công!
                            </p>










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
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển hàng Quảng Châu</a>
                                </li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển đường bộ</a></li>
                                <li><a href="#"><i class="bi bi-chevron-right"></i> Vận chuyển đường hàng không</a>
                                </li>
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
    </section>

    @include('layouts/footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>