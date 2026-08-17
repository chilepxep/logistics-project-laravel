<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quy định về ký gửi hàng - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css'])
    @vite(['resources/css/order-china.css'])
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
                    <li class="breadcrumb-item active" aria-current="page">Quy định ký gửi hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- NỘI DUNG CHÍNH -->
    <section class="pb-5">
        <div class="container">
            <div class="row g-4">

                <!-- CỘT TRÁI: NỘI DUNG BÀI VIẾT (9 CỘT) -->
                <div class="col-12 col-lg-9">
                    <div class="bg-white p-4 border shadow-sm rounded">

                        <!-- Tiêu đề -->
                        <h3 class="fw-bold text-uppercase mb-4 pb-3 border-bottom" style="color: #0b3a68;">
                            Quy định về ký gửi hàng
                        </h3>

                        <!-- Cảnh báo quan trọng đầu trang -->
                        <div class="alert alert-danger d-flex align-items-start mb-4 border-0 rounded-3"
                            style="background-color: #fff1f0;">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3 mt-1" style="color: #cf1322;"></i>
                            <div>
                                <p class="mb-2 fw-semibold" style="color: #cf1322;">QUY ĐỊNH BẮT BUỘC TRƯỚC KHI KÝ GỬI:
                                </p>
                                <p class="mb-0 text-dark" style="font-size: 14.5px; line-height: 1.6;">
                                    Chúng tôi chỉ nhận hàng ký gửi khi Khách hàng đã tạo đơn <strong>"HÀNG KÝ
                                        GỬI"</strong> trên hệ thống htkk360.com. Trường hợp những kiện hàng của Quý
                                    khách không thực hiện theo đúng quy trình ký gửi trên hệ thống như không tạo đơn ký
                                    gửi, để thông tin sai... Khi xảy ra rủi ro như mất hàng, <strong>HTKK sẽ hoàn toàn
                                        không chịu trách nhiệm.</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Danh sách mặt hàng CẤM -->
                        <h5 class="fw-bold mt-5 mb-3" style="color: #cf1322;">
                            <i class="bi bi-x-octagon-fill me-2"></i> Chú ý 1: Các mặt hàng HTKK KHÔNG NHẬN đặt và vận
                            chuyển
                        </h5>
                        <p class="text-muted mb-3" style="font-size: 14.5px;">Do yêu cầu về luật pháp & bảo quản hàng
                            hóa nên HTKK từ chối các mặt hàng sau:</p>

                        <div class="row g-3 mb-5 text-dark" style="font-size: 14px;">
                            <!-- Cột 1 của danh sách cấm -->
                            <div class="col-12 col-md-6">
                                <ul class="list-unstyled custom-list-prohibited">
                                    <li><i class="bi bi-x text-danger fs-5"></i> Vũ khí, đạn dược, vật liệu nổ, trang
                                        thiết bị kỹ thuật quân sự.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Pháo các loại, đèn trời, thiết bị gây
                                        nhiễu máy đo tốc độ.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Các chất ma túy và chất kích thích thần
                                        kinh.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Các sản phẩm dạng bột, thực phẩm, dược
                                        phẩm, mỹ phẩm.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Hàng giả, hàng nhái (Kể cả chính hãng
                                        Nike, Adidas).</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Sinh vật sống.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Thiết bị vô tuyến điện không phù hợp
                                        quy chuẩn.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Hóa chất độc, thuốc bảo vệ thực vật
                                        (Phụ lục III Công ước Rotterdam).</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Chất lỏng và các sản phẩm dạng lỏng.
                                    </li>
                                </ul>
                            </div>
                            <!-- Cột 2 của danh sách cấm -->
                            <div class="col-12 col-md-6">
                                <ul class="list-unstyled custom-list-prohibited">
                                    <li><i class="bi bi-x text-danger fs-5"></i> Phương tiện vận tải tay lái bên phải, ô
                                        tô/xe máy bị đục sửa số khung.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Vật tư, phương tiện đã qua sử dụng
                                        (Khung gầm, động cơ, ô tô cứu thương, xe đạp, mô tô...).</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Các loại văn hóa phẩm cấm, đồi trụy,
                                        phản động.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Hàng tiêu dùng đã qua sử dụng (Dệt may,
                                        điện tử, điện lạnh, y tế, nội thất, gốm sứ...).</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Phế liệu, phế thải, thiết bị làm lạnh
                                        sử dụng C.F.C.</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Sản phẩm, vật liệu chứa amiăng (nhóm
                                        amfibole).</li>
                                    <li><i class="bi bi-x text-danger fs-5"></i> Các sản phẩm liên quan lưu trữ dữ liệu
                                        (điện thoại, laptop,...).</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Danh sách HẠN CHẾ -->
                        <div class="p-3 mb-5 rounded"
                            style="background-color: #fff9e6; border-left: 4px solid #ffc107;">
                            <h6 class="fw-bold mb-2 text-dark"><i
                                    class="bi bi-exclamation-circle-fill text-warning me-2"></i> Một số sản phẩm bị HẠN
                                CHẾ nhập khẩu (Từ 11/03/2020):</h6>
                            <ul class="mb-0 text-dark" style="font-size: 14px;">
                                <li>Vải vóc (vải cuộn)</li>
                                <li>Linh kiện và máy móc công nghiệp, Linh kiện ô tô</li>
                                <li>Mỹ phẩm</li>
                                <li>Màn hình máy tính</li>
                            </ul>
                        </div>

                        <!-- CHÍNH SÁCH BỒI THƯỜNG -->
                        <h4 class="fw-bold mt-5 mb-4 text-uppercase" style="color: #0b3a68;">
                            <i class="bi bi-shield-check me-2 text-warning"></i> Chính sách giải quyết khiếu nại, bồi
                            thường với hàng ký gửi
                        </h4>

                        <p class="text-dark mb-4" style="font-size: 14.5px; line-height: 1.6;">
                            Do chúng tôi không trực tiếp giao dịch với nhà cung cấp của Quý khách, cũng không cung cấp
                            dịch vụ kiểm hàng cho các đơn hàng ký gửi. Hàng hóa của Quý khách được Nhà cung cấp vận
                            chuyển đến, chúng tôi chỉ nhận hàng theo số kiện Quý khách đã kê khai. <strong>Vì vậy chúng
                                tôi sẽ không chịu trách nhiệm đối với tình trạng hư hỏng hàng hoá, tính chính xác của
                                hàng hóa trước khi đến với kho của chúng tôi.</strong>
                        </p>

                        <div class="row g-4 mb-4">
                            <!-- Card: CÓ BẢO HIỂM -->
                            <div class="col-12 col-md-6">
                                <div class="card h-100 border-success shadow-sm">
                                    <div class="card-header bg-success text-white fw-bold">
                                        <i class="bi bi-check-circle-fill me-2"></i> KHI CÓ BẢO HIỂM HÀNG HÓA
                                    </div>
                                    <div class="card-body" style="font-size: 14px;">
                                        <p class="card-text text-success fw-semibold">Bồi thường 50% giá trị hàng hóa kê
                                            khai.</p>
                                        <p class="mb-3 text-muted">Phí bảo hiểm: <strong>5%</strong> trên tổng giá trị
                                            đơn hàng.</p>
                                        <div class="p-2 rounded bg-light border fst-italic">
                                            <strong>Ví dụ:</strong> Đơn hàng 10.000.000đ. Phí bảo hiểm 5% là 500.000đ.
                                            Nếu xảy ra thất lạc/hỏng do HTKK, đền bù <strong>5.000.000đ</strong>.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card: KHÔNG BẢO HIỂM -->
                            <div class="col-12 col-md-6">
                                <div class="card h-100 border-secondary shadow-sm">
                                    <div class="card-header bg-secondary text-white fw-bold">
                                        <i class="bi bi-x-circle-fill me-2"></i> KHI KHÔNG CÓ BẢO HIỂM
                                    </div>
                                    <div class="card-body" style="font-size: 14px;">
                                        <p class="card-text text-dark fw-semibold">Bồi thường gấp 3 lần số tiền cước vận
                                            chuyển.</p>
                                        <p class="text-muted">Áp dụng cho trường hợp thất lạc do lỗi của HTKK hoặc yếu
                                            tố khách quan khác.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="fst-italic text-danger mb-5" style="font-size: 13.5px;">
                            * Lưu ý: HTKK có quyền xác minh lại chính xác giá trị đơn hàng khi xảy ra tranh chấp. Nếu
                            giá trị hàng hóa mà quý khách kê khai cao hơn giá trị thực tế, chúng tôi sẽ không chấp nhận
                            đền bù thiệt hại.
                        </p>

                        <!-- Box Lưu ý 2 -->
                        <div class="p-4 bg-light border rounded text-center mb-5">
                            <h6 class="fw-bold text-uppercase mb-2" style="color: #0b3a68;">Chú ý 2</h6>
                            <p class="mb-2" style="font-size: 14.5px;">Nếu Quý khách đặt cọc tiền hàng sau 24 giờ mà
                                chưa nhận được tình trạng đặt hàng, vui lòng liên hệ ngay:</p>
                            <div class="fw-bold fs-4 text-warning mb-2"><i
                                    class="bi bi-telephone-inbound-fill me-2"></i> 024.66803049</div>
                            <p class="text-muted font-12 mb-0">Quý khách đặt và vận chuyển vui lòng tuân thủ đúng quy
                                trình hướng dẫn để hàng không bị thất lạc và được xử lý nhanh nhất. Xin cảm ơn!</p>
                        </div>

                        <!-- Call to Action -->
                        <div class="text-center pb-3">
                            <a href="#" class="btn rounded-pill px-5 py-2 text-white fw-bold hover-lift shadow"
                                style="background-color: #ff6a00; font-size: 15px;">
                                ĐĂNG KÝ NHẬN ƯU ĐÃI DỊCH VỤ HTKK TẠI ĐÂY <i class="bi bi-arrow-right-circle ms-2"></i>
                            </a>
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
        </div>
    </section>

    <!-- FOOTER -->
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>