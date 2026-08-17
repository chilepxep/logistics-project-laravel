<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câu hỏi thường gặp - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
    @vite(['resources/css/questions.css'])
</head>

<body class="bg-white">

    <!-- 1. HEADER -->
    @include('layouts.header')

    <!-- 2. BREADCRUMB -->
    <div class="py-2 border-bottom mb-5" style="background-color: #0b3a68;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 font-12">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-light">Trang chủ</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Câu hỏi thường gặp</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- 3. NỘI DUNG CHÍNH (CÂU HỎI THƯỜNG GẶP) -->
    <section class="pb-5">
        <div class="container">

            <!-- Tiêu đề trang -->
            <div class="text-center mb-5">
                <h2 class="text-uppercase fw-normal" style="color: #333;">CÂU HỎI THƯỜNG GẶP</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">

                    <!-- Khối Accordion -->
                    <div class="accordion custom-faq" id="faqAccordion">

                        <!-- Câu hỏi 1 (Mở sẵn mặc định) -->
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header">
                                <!-- Xóa class 'collapsed' để mở sẵn -->
                                <button class="accordion-button shadow-none bg-white text-dark fw-bold px-0"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                                    Tôi có phải làm hợp đồng khi sử dụng dịch vụ đặt hàng không?
                                    <span class="faq-icon ms-auto">
                                        <i class="bi bi-plus-circle-fill text-success icon-plus"></i>
                                        <i class="bi bi-dash-circle-fill text-success icon-minus"></i>
                                    </span>
                                </button>
                            </h2>
                            <!-- Thêm class 'show' để phần nội dung hiển thị mặc định -->
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Quy khách nên ký hợp đồng với công ty để đảm bảo quyền lợi và hiểu rõ những quy định
                                    mua hàng. Chúng tôi sẽ không chịu trách nhiệm với những trường hợp giao dịch ngoài,
                                    chuyển tiền cho cá nhân xử lý giúp đơn hàng hoặc quản lý giúp tài khoản.
                                    <br><br>
                                    -> Khi Quý khách đặt cọc tiền hàng tức là đã đồng ý với mọi quy định của chúng tôi,
                                    các trường hợp xảy ra khiếu nại chúng tôi sẽ áp dụng đúng theo các quy định đã nêu
                                    trên.
                                </div>
                            </div>
                        </div>

                        <!-- Câu hỏi 2 (Đóng mặc định) -->
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header">
                                <!-- Có class 'collapsed' để đóng sẵn -->
                                <button class="accordion-button collapsed shadow-none bg-white text-dark fw-bold px-0"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq2"
                                    aria-expanded="false">
                                    Thời gian vận chuyển hàng về Việt Nam thông thường mất bao lâu?
                                    <span class="faq-icon ms-auto">
                                        <i class="bi bi-plus-circle-fill text-success icon-plus"></i>
                                        <i class="bi bi-dash-circle-fill text-success icon-minus"></i>
                                    </span>
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Thông thường, thời gian vận chuyển từ kho Trung Quốc về Hà Nội mất từ 2-5 ngày, và
                                    về TP.HCM mất từ 5-7 ngày làm việc (không tính ngày lễ, Tết).
                                </div>
                            </div>
                        </div>

                        <!-- Câu hỏi 3 -->
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-none bg-white text-dark fw-bold px-0"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Bảng giá cước này có áp dụng chung cho tất cả khách hàng không?
                                    <span class="faq-icon ms-auto">
                                        <i class="bi bi-plus-circle-fill text-success icon-plus"></i>
                                        <i class="bi bi-dash-circle-fill text-success icon-minus"></i>
                                    </span>
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bảng giá trên áp dụng cho khách hàng tiêu chuẩn. Đối với khách hàng VIP hoặc khách
                                    hàng có sản lượng lớn, hệ thống sẽ tự động áp dụng các mức chiết khấu ưu đãi riêng
                                    theo từng cấp độ thành viên.
                                </div>
                            </div>
                        </div>

                        <!-- Bạn có thể copy/paste thêm nhiều câu hỏi tương tự tại đây -->

                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-none bg-white text-dark fw-bold px-0"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Bảng giá cước này có áp dụng chung cho tất cả khách hàng không?
                                    <span class="faq-icon ms-auto">
                                        <i class="bi bi-plus-circle-fill text-success icon-plus"></i>
                                        <i class="bi bi-dash-circle-fill text-success icon-minus"></i>
                                    </span>
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bảng giá trên áp dụng cho khách hàng tiêu chuẩn. Đối với khách hàng VIP hoặc khách
                                    hàng có sản lượng lớn, hệ thống sẽ tự động áp dụng các mức chiết khấu ưu đãi riêng
                                    theo từng cấp độ thành viên.
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Phân trang (Pagination) -->
                    <div class="d-flex justify-content-center mt-5">
                        <ul class="pagination pagination-sm custom-pagination gap-1">
                            <li class="page-item active"><a class="page-link rounded text-dark" href="#">1</a></li>
                            <li class="page-item"><a class="page-link rounded text-muted border-0" href="#">2</a></li>
                            <li class="page-item"><a class="page-link rounded text-muted border-0" href="#">sau ></a>
                            </li>
                            <li class="page-item"><a class="page-link rounded text-muted border-0" href="#">cuối »</a>
                            </li>
                        </ul>
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