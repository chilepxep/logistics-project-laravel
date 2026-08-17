<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hướng dẫn tạo đơn hàng- HTKK 360</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Hướng dẫn tạo đơn hàng</li>
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
                        <h4 class="mb-0 fs-5"><i class="bi bi-journal-text me-2"></i>Hướng dẫn cách tạo đơn hàng thông
                            qua giỏ hàng HTKK</h4>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="article-body">

                        <div class="toc-box border p-3 mb-4 rounded bg-light" style="max-width: 400px;">
                            <p class="fw-bold mb-2">Mục lục</p>
                            <ul class="list-unstyled mb-0" style="font-size: 14px;">
                                <li class="mb-1">
                                    <a href="#muc-1" class="text-decoration-none" style="color: #0b3a68;"> 1 Tạo đơn
                                        hàng qua HTKK </a>
                                </li>
                                <ul class="list-unstyled ms-3 mt-1">
                                    <li class="mb-1">
                                        <a href="#muc-1-1" class="text-decoration-none" style="color: #555;">
                                            1.1 Hướng dẫn tạo đơn hàng thông qua công cụ đặt hàng của HTKK
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="#muc-1-2" class="text-decoration-none" style="color: #555;">
                                            1.2 Hướng dẫn tạo đơn hàng trực tiếp trên website HTKK
                                        </a>
                                    </li>
                                </ul>
                                <li class="mb-1"><a href="#muc-2" class="text-decoration-none" style="color: #0b3a68;">2
                                        Hướng dẫn tạo đơn hàng trên app HTKK</a></li>
                            </ul>
                        </div>


                        <div class="service-content mb-5">

                            <h5 class="fw-bold mb-3">
                                Tạo đơn hàng qua HTKK
                            </h5>

                            <ul class="mb-0">
                                <span class="fw-normal d-block mb-3">
                                    Trên hệ thống của HTKK LOGISTICS hỗ trợ 2 cách tạo đơn hàng, tạo đơn bằng "Công cụ
                                    đặt hàng" hoặc "Gửi link và thông tin sản phẩm trực tiếp lên hệ thống website". HTKK
                                    LOGISTICS khuyến khích khách hàng tạo đơn hàng thông qua "Công cụ đặt hàng" giúp quý
                                    khách giao dịch nhanh chóng và dễ dàng trong việc quản lý đơn hàng.
                                </span>

                                <h5 class="fw-bold mb-3">
                                    Hướng dẫn tạo đơn hàng thông qua công cụ đặt hàng của HTKK
                                </h5>
                                <li class="mb-3">
                                    <strong>Bước 1:</strong>
                                    Sau khi cài add-on khách hàng đến thanh công cụ tìm kiếm của HTKK để lựa chọn tìm
                                    kiếm 1 trong những website của Trung Quốc: Taobao, 1688, tmall, Baidu..., sau đó gõ
                                    tên sản phẩm cần tìm, hệ thống tìm kiếm của HTKK sẽ gợi ý từ khóa quý khách cần tìm,
                                    quý khách chỉ việc lựa chọn từ khóa gợi ý hoặc click vào biểu tượng tìm kiếm. Hệ
                                    thống tìm kiếm của HTKK sẽ đưa quý khách đến trang, và sản phẩm quý khách cần tìm.
                                </li>

                                <p class="mb-3">
                                    Tìm kiếm nguồn nhập hàng Trung Quốc tại website HTKK.
                                </p>

                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Thanh công cụ tìm kiếm của HTKK
                                </p>

                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang1.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Hệ thống tìm kiếm của HTKK gợi ý từ khóa khách hàng cần tìm, HTKK lấy ví dụ tìm kiếm
                                    "Váy công sở nữ"
                                </p>


                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang2.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3">
                                    Giao diện và sản phẩm quý khách cần tìm sẽ hiện ra, khi đó quý khách sẽ thấy add-on
                                    quý khác vừa cài đặt hiện lên các thông tin bằng tiếng việt, quy đổi tiền Việt để
                                    quý khách dễ dàng xem và lựa chọn hơn.
                                </p>

                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang3.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Kết quả tìm kiếm được trả về
                                </p>
                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang4.png
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Lựa chọn một sản phẩm, sản phẩm đã được HTKK quy đổi giá ra VNĐ
                                </p>

                                <div class="container">

                                    <div class="p-2 my-4 text-black"
                                        style="background-color: #ff992f; font-size: 20px; line-height: 1.9;">

                                        <p class="mb-2">
                                            Đến đây, nếu bạn chưa có tài khoản Taobao, bạn nên tạo thêm 1 tài khoản
                                            trên Taobao để xem được đầy đủ thông tin hàng hóa mà Taobao hiển thị.
                                        </p>

                                        <div class="text-center">
                                            <a href="#" class="text-black fw-bold text-decoration-underline">
                                                &gt;&gt;&gt; Xem hướng dẫn chi tiết hướng dẫn cách tạo tài khoản
                                                trên Taobao.com
                                            </a>
                                        </div>

                                    </div>

                                </div>

                                <li class="mb-3">
                                    <strong>Bước 2:</strong>
                                    Khách hàng vào "Giỏ hàng" để kiểm tra thông tin sản phẩm
                                </li>

                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang5.png
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Sau khi lựa chọn sản phẩm theo size, màu sắc, số lượng... quý khách cho vào giỏ hàng
                                </p>

                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang6.png
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Sản phẩm đã được cho vào giỏ hàng
                                </p>

                                <p class="mb-3">
                                    Lựa chọn dịch vụ đi kèm. Trong các dịch vụ HTKK có cách danh mục dịch vụ gia tăng
                                    như kiểm đếm số lượng hàng hóa mà nhà cung cấp giao đến. Đóng gỗ các sản phẩm có
                                    tính chất dễ hỏng khi vận chuyển như bát đĩa, cốc chén, vali, máy móc....
                                </p>


                                <li class="mb-3">
                                    <strong>Bước 3:</strong>
                                    Đặt hàng và chờ báo giá
                                </li>

                                <p class="mb-3">
                                    Quý khách vui lòng kiểm tra các thông tin sản phẩm trong "Giỏ hàng"
                                </p>
                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang7.png
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Quý khách kiểm tra thông tin sản phẩm, điền thông tin mua hàng cùng kho nhận...
                                </p>
                                <p class="mb-3">
                                    Chọn "KHO NHẬN HÀNG" và "THÔNG TIN MUA HÀNG" rồi tiến hành "ĐẶT HÀNG" hoặc tiếp tục
                                    thêm các sản phẩm khác vào "Giỏ hàng" sau đó tiến hành "ĐẶT HÀNG".
                                </p>

                                <div class="text-center my-4">
                                    <img src="{{ asset('images/tao-don-hang7.png
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Sau tất cả các bước quý khách tiền hàng đặt hàng, trạng thái hiện tại của đơn hàng
                                    sẽ là chờ báo giá
                                </p>

                                <li class="mb-3">
                                    <strong>Bước 4:</strong>
                                    Đặt cọc.
                                </li>

                                <p class="mb-3">
                                    Quý khách có thể lựa chọn đặt cọc cho từng đơn hoặc tất cả các đơn hàng. <a href="#"
                                        class="text-bg-primary fw-bold text-decoration-underline">
                                        &gt;&gt;&gt; Xem hướng dẫn nạp tiền đặt cọc
                                    </a>
                                </p>


                                <p class="mb-3 fw-bolder">
                                    Lưu ý
                                </p>

                                <li>
                                    Đơn hàng quá 30 ngày không kết đơn sẽ bị xóa khỏi giỏ hàng
                                </li>

                                <li>
                                    Đối với các đơn hàng quá 30 ngày không đặt cọc hệ thống sẽ tự động xóa đơn hàng
                                </li>
                                <li>
                                    Sản phẩm đã chọn thông số (màu sắc, kích thước) trước khi cho vào giỏ hàng nhưng
                                    giỏ
                                    hàng không hiện, quý khách vui lòng lấy link sản phẩm -> xóa sản phẩm trong giỏ
                                    hàng
                                    rồi thực hiện lại các bước mua hàng như bình thường.
                                </li>

                                <li>
                                    Nếu xảy ra lỗi trong quá trình mua hàng bằng công cụ đặt hàng HTKK, quý khách
                                    vui
                                    lòng vào đây để thông báo cho bộ phận kĩ thuật của chúng tôi
                                </li>

                                <li>
                                    Trước khi cho hàng hóa từ các trang TMĐT vào giỏ khách hàng cần tắt chế độ dịch
                                    (nếu
                                    có) để tránh xảy ra lỗi khi đặt hàng.
                                </li>



                            </ul>

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