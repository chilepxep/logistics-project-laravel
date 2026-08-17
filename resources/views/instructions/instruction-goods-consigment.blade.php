<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hướng dẫn tạo đơn ký gửi hàng - HTKK 360</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Hướng dẫn tạo đơn ký gửi hàng
                    </li>
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
                        <h4 class="mb-0 fs-5"><i class="bi bi-journal-text me-2"></i>Hướng dẫn tạo đơn ký gửi hàng Trung
                            Quốc Quảng Châu về Việt Nam</h4>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="article-body">


                        <span class="fw-normal d-block mb-3">
                            Ký gửi hàng hóa tức là bạn đã hoàn thành tất cả các giao dịch với đối tác ở Trung Quốc và
                            chỉ sử dụng dịch vụ vận chuyển hàng từ Trung Quốc về Việt Nam của HTKK Logistics. Vậy quy
                            trình ký gửi hàng hóa được thực hiện như thế nào? Hãy cùng theo dõi ngay nội dung dưới đây.
                        </span>


                        <div class="toc-box border p-3 mb-4 rounded bg-light" style="max-width: 400px;">
                            <p class="fw-bold mb-2">Mục lục</p>
                            <ul class="list-unstyled mb-0" style="font-size: 14px;">
                                <li class="mb-1">
                                    <a href="#muc-1" class="text-decoration-none" style="color: #0b3a68;"> 1 Lý do nên
                                        lựa chọn ký gửi hàng hóa tại HTKK Logistics</a>
                                </li>
                                <ul class="list-unstyled ms-3 mt-1">
                                    <li class="mb-1">
                                        <a href="#muc-1-1" class="text-decoration-none" style="color: #555;">
                                            1.1 Tạo đơn ký gửi hàng Trung Quốc trên website HTKK
                                        </a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="#muc-1-2" class="text-decoration-none" style="color: #555;">
                                            1.2 Các mặt hàng cấm ký gửi tại HTKK
                                        </a>
                                    </li>
                                </ul>
                                <li class="mb-1"><a href="#muc-2" class="text-decoration-none" style="color: #0b3a68;">2
                                        2 Quy định ký gửi hàng Trung Quốc tại HTKK</a></li>
                            </ul>
                        </div>

                        <div class=" my-4">
                            <img src="{{ asset('images/kyguihang1.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                        </div>

                        <div class="service-content mb-5">

                            <h5 class="fw-bold mb-3">
                                Lý do nên lựa chọn ký gửi hàng hóa tại HTKK Logistics
                            </h5>

                            <ul class="mb-0">
                                <span class="fw-normal d-block mb-3">
                                    Nếu bạn đang tìm kiếm địa chỉ ký gửi hàng hóa uy tín từ Trung Quốc về Việt Nam, thì
                                    HTKK Logistics là sự lựa chọn tuyệt vời dành cho bạn, bởi lẽ, không chỉ có thời gian
                                    vận chuyển hàng nhanh chóng, HTKK còn mang đến nhiều lợi ích cho khách hàng, có thể
                                    kể đến như:
                                </span>

                                <ul class="mb-0">
                                    <li class="mb-3">
                                        <strong>Giá cước vận chuyển hợp lý</strong>
                                        Với cam kết giá vận chuyển luôn ở mức tốt nhất cho khách hàng chỉ từ 8000
                                        VNĐ/kg. HTKK Logistics đã, đang và ngày càng nhận được sự ủng hộ của khách hàng
                                        trong và ngoài nước.
                                    </li>

                                    <li class="mb-3">
                                        <strong>Phí dịch vụ mua hộ thấp nhất:</strong>
                                        Với phí dịch vụ mua hộ chỉ từ 1% giá trị đơn hàng, đây được xem là thế mạnh lớn
                                        nhất của HTKK Logistics mà khách hàng luôn chọn lựa.
                                    </li>


                                    <li class="mb-3">
                                        <strong>Hệ thống kho bãi:</strong>
                                        Hệ thống kho bãi rộng khắp trên cả nước, nằm gần kề các đường huyết mạch, xe
                                        container, xe tải lớn nhỏ ra vào thuận tiện 24/24. Đặc biệt có kho lớn tại Quảng
                                        Châu và Đông Hưng.
                                    </li>

                                    <li class="mb-3">
                                        <strong>Thủ tục hải quan thuận lợi:</strong>
                                        Là một trong số ít các công ty tại Việt Nam được cung cấp dịch vụ thủ tục hải
                                        quan dành cho hàng hóa…. Đến với HTKK Logistics, khách hàng sẽ được tư vấn đầy
                                        đủ quy trình và thủ tục giấy tờ cho các loại hình xuất và nhập khẩu.
                                    </li>

                                    <li class="mb-3">
                                        <strong>Bảo mật thông tin khách hàng:</strong>
                                        Bảo mật thông tin khách hàng là một trong những tiêu chí quan trọng hàng đầu của
                                        HTKK Logistics. Chúng tôi luôn nỗ lực không ngừng, ứng dụng những phương thức
                                        bảo mật tốt nhất để quản lý thông tin của hhách hàng tránh tình trạng cạnh
                                        tranh.
                                    </li>

                                    <li class="mb-3">
                                        <strong>An toàn hàng hóa:</strong>
                                        Hàng hóa được phục vụ bởi HTKK Logistics sẽ được cam kết vận chuyển một cách an
                                        toàn, chúng tôi sẽ đảm bảo quyền lợi tốt nhất cho khách hàng nhằm mang lại những
                                        trải nghiệm dịch vụ tốt nhất.

                                    </li>

                                    <li class="mb-3">
                                        <strong>Tốc độ giao hàng nhanh chóng:</strong>
                                        Với đội ngũ xe và nhân viên vận chuyển chuyên nghiệp kết hợp quy trình công nghệ
                                        hiện đại, chúng tôi luôn đảm bảo được thời gian và tốc độ giao hàng từ 3-5 ngày.
                                        Chúng tôi luôn nỗ lực để hàng hóa tới tay khách hàng nhanh và chính xác nhất.
                                    </li>

                                    <li class="mb-3">
                                        <strong>Cam kết hỗ trợ:</strong>
                                        Với đội ngũ chăm sóc và hỗ trợ khách hàng chuyên nghiệp, HTKK luôn có mặt để hỗ
                                        trợ một cách nhanh nhất khi khách hàng cần.
                                    </li>

                                    <li class="mb-3">
                                        <strong>Cam kết bồi thường: </strong>
                                        Cam kết bồi thường gấp 10 lần nếu hàng hóa của quý khách gặp vấn đề trong quá
                                        trình vận chuyển hoặc chênh lệch phát sinh trong quá trình xác nhận.
                                    </li>

                                    <li class="mb-3">
                                        <strong>Công nghệ quản lý và sử dụng dịch vụ: </strong>
                                        Với hệ thống công nghệ tiên tiến nhất hiện nay, HTKK đã xây dựng được 1 nền tảng
                                        tối ưu giúp hỗ trợ tốt nhất cho khách hàng trong quá trình theo dõi, quản lý và
                                        tra cứu hàng hóa của mình 24/7.
                                    </li>


                                </ul>

                                <h5 class="fw-bold mb-3">
                                    Tạo đơn ký gửi hàng Trung Quốc trên website HTKK
                                </h5>

                                <span class="fw-normal d-block mb-3">
                                    Quá trình ký gửi hàng hóa trên website được thực hiện rất đơn giản, nhưng nếu chủ
                                    shop vẫn chưa nắm được các bước ký gửi hàng hóa được thực hiện ra sao. Hãy cùng tham
                                    khảo một số bước sau đây.
                                </span>


                                <li class="mb-3">
                                    <strong>Bước 1:</strong>
                                    Khách hàng gửi hàng vào kho của HTKK Logistics
                                </li>

                                <li class="mb-3">
                                    <strong>Bước 2:</strong>
                                    Khách hàng vào trang chủ <a href=" http://htkk360.com"> http://htkk360.com</a>, đăng
                                    nhập tài khoản và bấm vào "Danh sách đơn hàng" như hình dưới.
                                </li>


                                <div class=" my-4">
                                    <img src="{{ asset('images/kyguihang2.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>
                                <p class="mb-3 fst-italic">
                                    Click và nút tạo đơn ký gửi để bắt đầu tạo đơn hàng
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Sau đó click chọn biểu tượng "TẠO ĐƠN KÝ GỬI"
                                    HTKK cũng khuyên khách hàng khi nhập hàng Trung Quốc hay order Taobao nên sử dụng
                                    dịch vụ đóng gỗ nếu sản phẩm cần vận chuyển dễ hỏng, vỡ như đồ gốm sứ, thủy tinh,
                                    máy móc, vali... Trong trường hợp sản phẩm cần vận chuyển ở danh mục hàng dễ vỡ mà
                                    khách hàng không chọn dịch vụ đóng gỗ, HTKK không chịu trách nhiệm khi hàng bị hỏng
                                    hay thiếu (bạn nên tìm hiểu kỹ về chính sách ký gửi hàng hóa)
                                </span>

                                <li class="mb-3">
                                    <strong>Bước 3:</strong>
                                    Nhập đầy đủ thông tin như trong hình, gồm: mã vận đơn, tên sản phẩm, số lượng kiện
                                    hàng, tên hãng vận chuyển, đặc biệt phần danh mục sản phẩm và phần mô tả sản phẩm
                                    (phần mũi tên chỉ đỏ) bắt buộc phải nhập.
                                </li>


                                <div class=" my-4">
                                    <img src="{{ asset('images/kyguihang3.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>
                                <p class="mb-3 fst-italic">
                                    Điền đúng mã vận đơn, hãng vận chuyển, giá trị đơn...
                                </p>

                                <div class=" my-4">
                                    <img src="{{ asset('images/kyguihang4.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>
                                <p class="mb-3 fst-italic">
                                    Lựa chọn kho nhận hàng, địa chỉ nhận hàng tại Việt Nam
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Sau khi các thông tin được điền đầy đủ theo yêu cầu, Khách hàng tiến hành TẠO ĐƠN KÝ
                                    GỬI bằng nút phía bên dưới để kết thúc quá trình tạo đơn.
                                </span>


                                <div class=" my-4">
                                    <img src="{{ asset('images/kyguihang5.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>
                                <p class="mb-3 fst-italic">
                                    Tạo đơn ký gửi, đơn hàng của bạn đã được hoàn tất
                                </p>

                                <div class=" my-4">
                                    <img src="{{ asset('images/kyguihang6.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>
                                <p class="mb-3 fst-italic">
                                    Mã vận đơn sau khi hoàn thành
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Như vậy là bạn đã tạo xong 1 đơn hàng ký gửi thành công. Thông tin đơn hàng nếu bạn
                                    nhập chính xác, hệ thống HTKK sẽ tiếp nhận đơn hàng của bạn và báo giá ngay lập tức.
                                    Mọi thắc mắc hay cần tư vấn về dịch vụ vận chuyển hàng Trung Quốc về Việt Nam vui
                                    lòng liên hệ bộ phận CSKH của HTKK Logitics.
                                </span>


                                <h5 class="fw-bold mb-3">
                                    Quy định ký gửi hàng Trung Quốc tại HTKK
                                </h5>

                                <span class="fw-normal d-block mb-3">
                                    Nhằm phục vụ tốt nhất cho nhu cầu ký gửi hàng hóa từ Trung Quốc về Việt Nam, chủ
                                    shop, người sử dụng dịch vụ ký gửi nên nắm được một số quy định về ký gửi hàng hóa
                                    Trung Quốc tại HTKK Logistics như sau:
                                </span>
                                <p class="mb-3">
                                    Các mặt hàng được phép ký gửi tại HTKK
                                </p>

                                <div class=" my-4">
                                    <img src="{{ asset('images/kyguihang7.jpg
                            ') }}" class="img-fluid border" alt="Quy trình kiểm đếm">
                                </div>

                                <ul class="mb-0">
                                    <li class="mb-3">

                                        Các sản phẩm thời trang bao gồm quần áo mọi lứa tuổi, giày dép, túi xách, phụ
                                        kiện làm đẹp, trang trí nhà cửa sân vườn.
                                    </li>

                                    <li class="mb-3">

                                        Các mặt hàng điện tử bao gồm máy tính, điện thoại, phụ kiện điện thoại, máy
                                        tính, loa, máy chiếu, hệ thống âm thanh, máy chơi game…
                                    </li>
                                    <li class="mb-3">

                                        Các sản phẩm đồ gia dụng.
                                    </li>

                                    <li class="mb-3">

                                        Các sản phẩm đồ nội thất bao gồm sập, tủ rượu, tủ quần áo, giá đựng đồ…
                                    </li>
                                    <li class="mb-3">

                                        Các mặt hàng phụ kiện, linh kiện, ôtô, xe máy.
                                    </li>
                                    <li class="mb-3">

                                        Các loại máy móc.
                                    </li>
                                </ul>

                                <p class="mb-3">
                                    Các mặt hàng cấm ký gửi tại HTKK
                                </p>

                                <span class="fw-normal d-block mb-3">
                                    Ngoài những mặt hàng được phép ký gửi theo đúng quy định của pháp luật, HTKK sẽ
                                    không nhận ký gửi một số mặt hàng thuộc phạm vi cấm của nhà nước như:
                                </span>

                                <ul class="mb-0">
                                    <li class="mb-3">
                                        Các chất kích thích, chất gây nghiện như thuốc lá điện tử, ma túy, cần sa, chất
                                        gây kích thích thần kinh.
                                    </li>

                                    <li class="mb-3">
                                        Các loại vũ khí, thiết bị sử dụng trong hoạt động quân sự như súng, đạn, dao,
                                        kiếm, kéo...
                                    </li>
                                    <li class="mb-3">
                                        Các sản phẩm thực phẩm chức năng, thuốc, hóa chất, đồ ăn…
                                    </li>

                                    <li class="mb-3">
                                        Các sản phẩm văn hóa thuộc diện cấm của nhà nước như tài liệu phản động, văn hóa
                                        phẩm đồ trụy…
                                    </li>
                                    <li class="mb-3">
                                        Các sản phẩm dễ cháy nổ, gây hại môi trường như thuốc nổ, pháo, hóa chất độc
                                        hại…
                                    </li>
                                    <li class="mb-3">
                                        Sinh vật sống.
                                    </li>
                                </ul>

                                <span class="fw-normal d-block mb-3">
                                    Một số sản phẩm bị hạn chế nhập khẩu tại (áp dụng từ ngày 11/03/2020):
                                </span>

                                <ul class="mb-0">
                                    <li class="mb-3">
                                        Vải vóc (vải cuộn).
                                    </li>

                                    <li class="mb-3">
                                        Linh kiện và máy móc công nghiệp.
                                    </li>
                                    <li class="mb-3">
                                        Linh kiện ô tô.
                                    </li>

                                    <li class="mb-3">
                                        Mỹ phẩm.
                                    </li>
                                    <li class="mb-3">
                                        Màn hình máy tính.
                                    </li>
                                </ul>

                                <span class="fw-normal d-block mb-3">
                                    Mong rằng với thông tin chi tiết về cách tạo đơn hàng ký gửi trên website và app
                                    trên đây sẽ giúp chủ shop tạo đơn ký gửi hàng hóa một cách dễ dàng. Mọi thắc mắc hay
                                    cần tư vấn về dịch vụ vận chuyển hàng Trung Quốc về Việt Nam vui lòng liên hệ bộ
                                    phận CSKH của HTKK Logistics để được giải đáp tốt nhất.
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