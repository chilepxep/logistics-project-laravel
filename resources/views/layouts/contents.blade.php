@extends('layouts.app')
<!-- Giả sử bạn có file layout chính -->

@section('content')
<!-- Đường dẫn Breadcrumb -->
<div class="bg-light py-2">
    <div class="container">
        <small class="text-muted">Trang chủ > Dịch vụ > <span class="text-primary">Dịch vụ kiểm đếm</span></small>
    </div>
</div>

<div class="container py-4">
    <div class="row">

        <!-- CỘT TRÁI: NỘI DUNG BÀI VIẾT -->
        <div class="col-12 col-lg-9 mb-4">
            <h3 class="fw-bold text-uppercase mb-3" style="color: #0b3a68;">DỊCH VỤ KIỂM ĐẾM</h3>

            <!-- Khu vực bài viết được bọc trong class post-content -->
            <div class="post-content">
                <p>Nội dung văn bản mô tả dịch vụ từ database sẽ được đổ vào đây...</p>

                <!-- Bảng 1: Bảng giá kiểm đếm (Ví dụ) -->
                <table>
                    <thead>
                        <tr>
                            <th>Số lượng</th>
                            <th>Mức phí (VNĐ/sản phẩm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Từ 1 đến 500 sản phẩm</td>
                            <td>1,000đ</td>
                        </tr>
                        <tr>
                            <td>Từ 501 đến 1000 sản phẩm</td>
                            <td>800đ</td>
                        </tr>
                        <tr>
                            <td>Trên 1000 sản phẩm</td>
                            <td>500đ</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Bạn có thể chèn bao nhiêu bảng tùy ý vào đây, CSS sẽ tự động lo hết -->
            </div>
        </div>

        <!-- CỘT PHẢI: SIDEBAR -->
        <div class="col-12 col-lg-3">
            <div class="sidebar-box border">
                <div class="bg-primary text-white p-2 fw-bold text-uppercase"
                    style="background-color: #0b3a68 !important;">
                    Dịch vụ của chúng tôi
                </div>
                <ul class="list-unstyled p-3 mb-0" style="font-size: 14px;">
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Dịch vụ đặt hàng</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Dịch vụ vận chuyển</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-dark">Dịch vụ kiểm đếm</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection