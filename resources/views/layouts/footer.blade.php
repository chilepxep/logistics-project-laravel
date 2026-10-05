<!-- BƯỚC 9: FOOTER -->
<footer class="pt-5 pb-3" style="background-color: #0b3a68; color: #d1d5db;">
    <div class="container">
        <div class="row g-4 mb-4">

            <!-- Cột 1: Thông tin công ty -->
            <div class="col-12 col-md-4">
                <a class="navbar-brand fw-bold fs-3 mb-3 d-block" href="#">
                    <span class="text-warning">HTKK</span> <span class="text-white">360</span>
                </a>


                @if(!empty($globalSetting->addresses) && is_array($globalSetting->addresses))
                @foreach($globalSetting->addresses as $address)
                <p class="mb-2"><i class="bi bi-geo-alt-fill text-warning me-2"></i>{{ $address }}
                    @endforeach
                    @else
                    <li>Đang cập nhật địa chỉ...</li>
                    @endif

                <p class="mb-2"><i class="bi bi-envelope-fill text-warning me-2"></i><strong>Email:
                        {{ $globalSetting->email ?? 'Đang cập nhật' }}</strong>
            </div>

            <!-- Cột 2: Về HTKK -->
            <div class="col-6 col-md-2">
                <h6 class="text-white fw-bold mb-3 text-uppercase">Về chúng tôi</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Bảng giá</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Chính sách khiếu nại</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                </ul>
            </div>

            <!-- Cột 3: Hướng dẫn -->
            <div class="col-6 col-md-3">
                <h6 class="text-white fw-bold mb-3 text-uppercase">Hướng dẫn khách hàng</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Hướng dẫn tạo tài khoản</a></li>
                    <li><a href="#">Hướng dẫn cài đặt công cụ</a></li>
                    <li><a href="#">Hướng dẫn lên đơn hàng</a></li>
                    <li><a href="#">Hướng dẫn nạp tiền</a></li>
                    <li><a href="#">Câu hỏi thường gặp (FAQ)</a></li>
                </ul>
            </div>

            <!-- Cột 4: Hỗ trợ & Mạng xã hội -->
            <div class="col-12 col-md-3">
                <h6 class="text-white fw-bold mb-3 text-uppercase">Hỗ trợ khách hàng</h6>
                <div class="mb-3">
                    <p class="text-warning fw-bold fs-5 mb-0">{{ $globalSetting->hotline ?? 'Đang cập nhật' }}</p>
                    <small>Hotline hỗ trợ (8:00 - 17:30)</small>
                </div>

                <h6 class="text-white fw-bold mb-3 mt-4 text-uppercase">Kết nối với chúng tôi</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

        </div>

        <!-- Dòng Bản quyền cuối cùng -->
        <div class="row pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
            <div class="col-md-6 text-center text-md-start">
                <small>&copy; 2026 HTKK 360 Logistics. All rights reserved.</small>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <!-- Ảnh chứng nhận DMCA / Bộ Công Thương (nếu có) -->
                <!-- <img src="bo-cong-thuong.png" height="30"> -->
            </div>
        </div>
    </div>
</footer>