@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')


<div class="container-fluid mt-4 px-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Tiêu đề trang -->
            <div class="text-center mb-5">
                <h2 class="text-uppercase fw-bold" style="color: #0b3a68;">Hướng dẫn nạp tiền vào tài khoản khách hàng
                    của HTKK</h2>
                <p class="text-muted fs-5">Có rất nhiều cách nạp tiền vào tài khoản khách hàng tại HTKK để lưu trữ và
                    chi trả cho các dịch vụ. Dưới đây là 3 cách nạp tiền chi tiết nhất.</p>
            </div>

            <!-- Mục lục -->
            <div class="card shadow-sm border-0 mb-5" style="background-color: #f8f9fa;">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-list-ul me-2"></i> Mục Lục [Ẩn]</h5>
                    <ul class="list-unstyled lh-lg mb-0 font-15">
                        <li><a href="#3-cach" class="text-decoration-none text-dark fw-semibold">1. 3 cách nạp tiền vào
                                tài khoản khách hàng tại HTKK</a>
                            <ul class="list-unstyled ms-4">
                                <li><a href="#cach-1" class="text-decoration-none text-primary">1.1 Chuyển khoản qua
                                        ngân hàng</a></li>
                                <li><a href="#noi-dung" class="text-decoration-none text-primary">1.2 Nội dung chuyển
                                        tiền</a></li>
                                <li><a href="#cach-2" class="text-decoration-none text-primary">1.3 Chuyển khoản qua ATM
                                        hoặc các dịch vụ khác</a></li>
                                <li><a href="#cach-3" class="text-decoration-none text-primary">1.4 Nạp tiền trực tiếp
                                        tại các trụ sở của HTKK</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Nội dung chi tiết -->
            <div class="content-section" style="line-height: 1.8; font-size: 15px;">

                <h4 id="3-cach" class="fw-bold text-uppercase mb-3" style="color: #0b3a68;">3 cách nạp tiền vào tài
                    khoản khách hàng tại HTKK</h4>
                <p>Để thanh toán/ đặt cọc các đơn hàng của quý khách được nhanh chóng và thuận tiện nhất. Quý khách vui
                    lòng nạp tiền vào tài khoản mua hàng của mình trên website HTKK theo những cách cụ thể trong bài
                    viết này.</p>

                <hr class="my-4">

                <h5 id="cach-1" class="fw-bold text-danger mb-3">1. Chuyển khoản qua ngân hàng</h5>
                <p>Quý khách có thể chuyển khoản vào một trong những tài khoản ngân hàng của HTKK. Để thuận tiện quý
                    khách có thể sử dụng dịch vụ Internet Banking (hầu hết ngân hàng nào cũng có) trên điện thoại để
                    chuyển tiền bất cứ lúc nào.</p>
                <p>Ngoài ra quý khách có thể đến các quầy giao dịch trực tiếp để chuyển khoản cho HTKK. Đến các quầy
                    giao dịch thì không cần yêu cầu phải có tài khoản ngân hàng, chỉ cần mang Chứng minh thư nhân dân/
                    Thẻ căn cước công dân là có thể thực hiện chuyển tiền. Tùy từng ngân hàng sẽ mất thêm phí giao dịch
                    khi chuyển khoản khác ngân hàng.</p>

                <!-- Bảng tài khoản ngân hàng -->
                <div class="table-responsive my-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center fw-bold">
                            <tr>
                                <th style="width: 30%;">Ngân hàng</th>
                                <th style="width: 40%;">Tài khoản</th>
                                <th style="width: 30%;">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center fw-bold text-success">Vietcombank</td>
                                <td>
                                    <div>STK: <span class="fw-bold fs-5 text-danger">0123456789</span></div>
                                    <div>CTK: HTKK LOGISTICS</div>
                                    <div>Chi nhánh: Sở giao dịch Hà Nội</div>
                                </td>
                                <td>...</td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-primary">Techcombank</td>
                                <td>
                                    <div>STK: <span class="fw-bold fs-5 text-danger">9876543210</span></div>
                                    <div>CTK: HTKK LOGISTICS</div>
                                    <div>Chi nhánh: Cầu Giấy</div>
                                </td>
                                <td>...</td>
                            </tr>
                            <!-- Bạn có thể sửa nội dung bảng trên cho đúng STK của bạn -->
                        </tbody>
                    </table>
                </div>

                <h5 id="noi-dung" class="fw-bold text-danger mt-5 mb-3">Nội dung chuyển tiền</h5>
                <p>Để đảm bảo tiền được chuyển vào tài khoản HTKK nhanh nhất, giúp khách hàng nhanh chóng thanh toán/
                    đặt cọc các đơn đặt hàng Trung Quốc. Quý khách vui lòng chuyển tiền với nội dung sau:</p>

                <!-- Highlight Cú pháp -->
                <div
                    class="alert alert-warning border-start border-warning border-4 text-dark fs-5 py-3 my-3 shadow-sm">
                    <strong>Cú pháp:</strong> <span class="text-danger fw-bold">HV [Số điện thoại đăng ký] [Họ và
                        tên]</span><br>
                    <span class="fs-6 text-muted">(Ví dụ: HV 09633516 Phạm Văn A)</span>
                </div>

                <div class="alert alert-info py-2">
                    <strong><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Lưu ý:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Quý khách chú ý soạn đúng cú pháp để việc nạp tiền giao dịch được nhanh chóng nhất.</li>
                        <li>Số điện thoại sử dụng <strong>phải là số điện thoại</strong> khách hàng đăng ký tài khoản
                            thành viên trên hệ thống của HTKK.</li>
                    </ul>
                </div>

                <hr class="my-5">

                <h5 id="cach-2" class="fw-bold text-danger mb-3">2. Chuyển khoản qua ATM hoặc các dịch vụ khác</h5>
                <p>Nếu quý khách không thể chuyển khoản qua ngân hàng thì có thể sử dụng chuyển khoản qua cây ATM. Tuy
                    nhiên khi lựa chọn chuyển tiền qua cây ATM sẽ không có phần ghi chú và cần có thẻ ngân hàng. Sau khi
                    thực hiện giao dịch qua ATM, quý khách vui lòng soạn tin nhắn với cú pháp và gửi đến số điện thoại
                    sau:</p>

                <!-- Highlight Cú pháp SMS -->
                <div
                    class="alert alert-success border-start border-success border-4 text-dark fs-5 py-3 my-3 shadow-sm">
                    <span class="text-danger fw-bold">HV [Tên ngân hàng] [Số điện thoại] [Số tiền đã nạp] [Họ và
                        tên]</span>
                    gửi <span class="fw-bold text-primary">0834517229</span><br>
                    <span class="fs-6 text-muted">(Ví dụ: HV Techcombank 09633516 1.000.000)</span>
                </div>
                <p>Hoặc liên hệ trực tiếp tới bộ phận chăm sóc khách hàng: <strong
                        class="text-danger">024.66803049</strong> để được hỗ trợ nhanh nhất.</p>

                <hr class="my-5">

                <h5 id="cach-3" class="fw-bold text-danger mb-3">3. Nạp tiền trực tiếp tại các trụ sở của HTKK</h5>
                <p>Ngoài 2 cách nạp tiền vào tài khoản HTKK ở phía trên, quý khách hàng, các chủ shop có thể đến trực
                    tiếp các trụ sở chính của HTKK tại một trong 2 địa chỉ dưới đây để thực hiện nạp tiền vào tài khoản.
                </p>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><i class="bi bi-geo-alt-fill text-danger me-2"></i> <strong>Trụ Sở Hà
                            Nội:</strong> Số 117 Trần Duy Hưng - Cầu Giấy - Hà Nội</li>
                    <li class="list-group-item"><i class="bi bi-geo-alt-fill text-danger me-2"></i> <strong>Trụ Sở Hồ
                            Chí Minh:</strong> Số 911 Nguyễn Trãi, Phường 14, Quận 5, Hồ Chí Minh</li>
                </ul>

                <hr class="my-5">

                <!-- PHẦN CHÈN ẢNH HƯỚNG DẪN -->
                <h5 class="fw-bold text-uppercase text-center mb-4" style="color: #0b3a68;">QR chuyển khoản:</h5>
                <div class="text-center mb-5">
                    <!-- Sửa link 'src' dưới đây thành link ảnh thực tế của bạn -->
                    <img src="{{ asset('images/chuyen-khoan.jpg') }}" alt="Số dư tài khoản"
                        class="img-fluid shadow rounded border"
                        style="max-height: 400px; width: 100%; object-fit: contain; background: #f1f1f1;">
                    <div class="mt-2 text-muted font-13 fst-italic">Lưu ý nội dung chuyển khoản</div>
                </div>

                <!-- Kết luận -->
                <div class="bg-light p-4 rounded text-center shadow-sm">
                    <p class="mb-0">Trên đây là 3 cách nạp tiền vào tài khoản HTKK chi tiết nhất, hi vọng các chủ shop
                        và người sử dụng dịch vụ có thể lựa chọn cho mình một hình thức nạp tiền phù hợp nhất. Mọi thông
                        tin chi tiết về dịch vụ, hãy liên hệ đến <strong>HTKK Logistics</strong> để được giải đáp tốt
                        nhất.</p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection