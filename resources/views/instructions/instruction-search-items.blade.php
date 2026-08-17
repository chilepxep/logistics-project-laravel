<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hướng dẫn tìm hàng TaoBao - HTKK 360</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Hướng dẫn cách tự order mua hàng trên Taobao
                    </li>
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
                        <h4 class="mb-0 fs-5"><i class="bi bi-journal-text me-2"></i>Hướng dẫn cách tự order mua hàng
                            trên Taobao Tmall </h4>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="article-body">

                        <div class="toc-box border p-3 mb-4 rounded bg-light" style="max-width: 400px;">
                            <p class="fw-bold mb-2">Mục lục</p>
                            <ul class="list-unstyled mb-0" style="font-size: 14px;">
                                <li class="mb-1">
                                    <a href="#muc-1" class="text-decoration-none" style="color: #0b3a68;"> 1 Order
                                        Taobao 1688 tmall là gì? </a>
                                </li>
                                <ul class="list-unstyled ms-3 mt-1">
                                    <li class="mb-1">
                                        <a href="#muc-1-1" class="text-decoration-none" style="color: #555;">
                                            1.1 Taobao.com
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="#muc-1-2" class="text-decoration-none" style="color: #555;">
                                            1.2 Tìm nguồn hàng bằng hình ảnh
                                        </a>
                                    </li>
                                </ul>
                                <li class="mb-1"><a href="#muc-2" class="text-decoration-none" style="color: #0b3a68;">2
                                        Dịch vụ order và vận chuyển hàng Taobao Tmall 1688 của HTKK Logistics</a></li>
                            </ul>
                        </div>


                        <div class="service-content mb-5">

                            <h5 class="fw-bold mb-3">
                                Order Taobao 1688 là gì?
                            </h5>

                            <ul class="mb-0">
                                <span class="fw-normal d-block mb-3">
                                    Taobao tmall 1688 trên thực tế là những trang thương mại điện tử thuộc tập đoàn
                                    Alibaba Group của Trung Quốc. Đây là nơi có kho hàng khổng lồ đến từ nhiều nhà cung
                                    cấp ở Trung Quốc và trên thế giới. Dù được phát triển từ một cùng một tập đoàn lớn,
                                    nhưng 3 trang website sẽ có cách thức hoạt động hoàn toàn khác nhau.
                                </span>

                                <p class="mb-3">
                                    Taobao.com
                                </p>

                                <div class=" my-4">
                                    <img src="{{ asset('images/taobao1.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Giao diện trang chủ Tmall
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Taobao.com là trang thương mại điện tử bán lẻ hoạt động theo mô hình C2C. Có thể
                                    hiểu đây là nơi trung gian gắn kết giữa nhà cung cấp, các shop bán lẻ với người tiêu
                                    dùng. Hoạt động theo hình thức miễn phí, nên Taobao có số lượng shop kinh doanh lớn
                                    nhất trong 3 trang web.
                                    Taobao bán tất cả các mặt hàng từ đồ gia dụng, mỹ phẩm, đồ điện tử, thiết bị, phụ
                                    kiện…song mặt hàng nổi bật nhất vẫn là đồ thời trang. Đến với Taobao, người dùng
                                    hoàn toàn có thể tìm được những mặt hàng độc, lạ với mức giá phải chăng.
                                </span>


                                <h5 class="fw-bold mb-3">
                                    Cách tìm nguồn order hàng trên Taobao 1688 và Tmall
                                </h5>

                                <p class="mb-3">
                                    Tìm nguồn hàng bằng hình ảnh
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Tìm nguồn hàng bằng hình ảnh là tính năng hữu ích được Alibaba triển khai cho kênh
                                    1688, Taobao. So với những cách tìm kiếm thông dụng khác thì, tìm bằng hình ảnh sẽ
                                    cho ra kết quả chính xác đến 99% sản phẩm mà bạn đang muốn tìm
                                </span>

                                <p class="mb-3">
                                    Tìm kiếm nguồn hàng bằng hình ành trên Taobao
                                </p>

                                <li class="mb-3">
                                    <strong>Bước 1:</strong>
                                    Truy cập vào trang chủ Taobao, Bạn truy cập vào trang chủ Taobao
                                    https://world.taobao.com/ sau đó tiến bấm dịch sang tiếng Việt để dễ dàng tìm kiếm.
                                </li>

                                <div class=" my-4">
                                    <img src="{{ asset('images/taobao2.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Truy cập trang chủ Taobao
                                </p>

                                <li class="mb-3">
                                    <strong>Bước 2:</strong>
                                    Chọn biểu tượng camera trên thanh tìm kiếm Taobao
                                </li>


                                <div class=" my-4">
                                    <img src="{{ asset('images/taobao2.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Chọn biểu tượng camera trên thanh công cụ để tìm kiếm
                                </p>

                                <p class="mb-3">
                                    Bấm vào biểu tượng camera ở bên phải thanh tìm kiếm, sẽ xuất hiện ra một cửa sổ.
                                    Chọn các sản phẩm mà mình cần tìm kiếm và đã lưu lại trước đó để tìm kiếm. Chỉ sau
                                    vài giây, các sản phẩm tương tự mà bạn cần tìm kiếm sẽ hiện tra và bạn sẽ dễ dàng
                                    tìm được sản phẩm như ý muốn
                                </p>

                                <h5 class="fw-bold mb-3">
                                    Dịch vụ order và vận chuyển hàng Taobao Tmall 1688 của HTKK Logistics
                                </h5>

                                <span class="fw-normal d-block mb-3">
                                    Là đơn vị hoạt động lâu năm trong lĩnh vực order và vận chuyển hàng Taobao Tmall
                                    1688, HTKK Logistics hỗ trợ khách hàng tìm kiếm nguồn hàng, thương lượng với nhà
                                    cung cấp, đặt hàng và vận chuyển từ Trung Quốc về Việt Nam nhanh chóng, an toàn.
                                    Theo đó khi đặt hàng Taobao, Tmall, 1688 tại HTKK bạn sẽ nhận được những lợi ích như
                                    sau:
                                </span>

                                <p class="mb-3 fw-bold">
                                    Cước phí mua hộ và vận chuyển thấp
                                </p>
                                <span class="fw-normal d-block mb-3">
                                    Cước phí mua hộ thấp nhất thị trường chỉ 9.000đ/kg đối với đơn hàng lẻ, nếu vận
                                    chuyển đơn hàng lớn cước phí sẽ rẻ hơn rất nhiều. Cước phí mua hộ và vận chuyển hàng
                                    hóa được công bố công khai trên hệ thống.

                                    Với kinh nghiệm nhiều năm trong ngành đặt hàng và vận chuyển hàng Trung - Việt, HTKK
                                    dễ dàng thương lượng chi phí và nhập hàng với mức thấp nhất cho khách hàng.
                                </span>

                                <p class="mb-3 fw-bold">
                                    Đội ngũ nhân viên chuyên nghiệp, hỗ trợ 24/7
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Đội ngũ nhân viên hỗ trợ đặt hàng chuyên nghiệp, có kinh nghiệm trong việc đàm phán
                                    với các nhà cung cấp Trung Quốc. Vì thế, sẽ giúp khách hàng tìm được nguồn hàng uy
                                    tín, chất lượng và giá rẻ.
                                </span>

                                <div class=" my-4">
                                    <img src="{{ asset('images/taobao4.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <p class="mb-3 fst-italic">
                                    Mua hàng Alibaba1688, taobao, tmall
                                </p>

                                <p class="mb-3 fw-bold">
                                    Chính sách bảo hiểm và đền bù 100% hàng hóa khi mất mát, thất lạc
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Với những trường hợp hàng hóa hư hỏng, mất mát lỗi do trách nhiệm của HTKK, chúng
                                    tôi luôn cam kết hoàn trả 100 % giá trị tiền hàng. Trong trường hợp nhầm hàng, hàng
                                    lỗi, HTKK sẽ hỗ trợ khách hàng khiếu nại và đổi trả hàng hóa trực tiếp với nhà sản
                                    xuất bên phía Trung Quốc.
                                </span>

                                <p class="mb-3 fw-bold">
                                    Vận chuyển chính ngạch an toàn hàng về nhanh chóng
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Trên thực tế, có nhiều công ty vận chuyển hàng hóa theo đường tiểu ngạch khiến hàng
                                    hóa chậm trễ do tắc biên, mất hàng, hàng hóa bị thu giữ do không đủ giấy tờ. Để
                                    tránh tình trạng này, HTKK nhận vận chuyển hàng chính ngạch, hóa đơn, chứng từ rõ
                                    ràng. Do đó, hàng hóa luôn đảm bảo an toàn và hạn chế được tình trạng hàng hóa bị
                                    thất lạc, mất mát.
                                </span>
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