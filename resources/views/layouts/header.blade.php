    <header class="sticky-top" style="z-index: 1030;">

        <!-- Topbar -->
        <div class="topbar text-white py-1" style="background-color: #0b3a68;">
            <div class="container d-none d-md-flex justify-content-between font-12">

                <div class="contact-info">
                    <span class="me-3">
                        <i class="bi bi-telephone text-warning"></i>
                        Hotline: 0123 456 789
                    </span>

                    <span>
                        <i class="bi bi-envelope text-warning"></i>
                        Email: hotro@htkk360.com
                    </span>
                </div>

                <div class="user-actions">
                    @guest
                    <!-- Khi CHƯA đăng nhập -->
                    <a href="{{ route('login') }}" class="text-white text-decoration-none me-3 font-13 hover-warning">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
                    </a>
                    <span class="text-white-50 me-3">/</span>
                    <a href="{{ route('register') }}" class="text-white text-decoration-none font-13 hover-warning">
                        Đăng ký
                    </a>
                    @endguest

                    @auth
                    <!-- Khi ĐÃ đăng nhập -->
                    <div class="dropdown">
                        <div class="d-flex align-items-center gap-2">


                            <!-- Danh sách đơn hàng -->
                            <a href="{{ route('dashboard') }}" class="order-btn text-decoration-none">

                                <i class="bi bi-journal-bookmark-fill me-1"></i>
                                Danh sách đơn hàng
                            </a>

                            <!-- Tài khoản -->
                            <a href="#" class="text-white text-decoration-none dropdown-toggle font-13"
                                data-bs-toggle="dropdown">

                                <i class="bi bi-person-circle text-warning me-1"></i>
                                <strong>{{ Auth::user()->ho_ten }}</strong>
                            </a>


                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 font-14">
                                <li>
                                    <h6 class="dropdown-header">Số dư: <span
                                            class="text-danger fw-bold">{{ number_format(Auth::user()->so_du, 0, ',', '.') }}
                                            đ</span></h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Thông tin cá
                                        nhân</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-box-seam me-2"></i>Quản lý đơn
                                        hàng</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 font-14">
                            <li>
                                <h6 class="dropdown-header">Số dư: <span
                                        class="text-danger fw-bold">{{ number_format(Auth::user()->so_du, 0, ',', '.') }}
                                        đ</span></h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Thông tin cá nhân</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-seam me-2"></i>Quản lý đơn
                                    hàng</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endauth
                </div>

            </div>
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0b3a68;">

            <div class="container">

                <a href="{{ route('homepage') }}">
                    <img src="{{ asset('images/logo_3.png') }}" class="img-fluid logo" alt="HTKK 360">
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav mx-auto fw-semibold">

                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" id="dichVuDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                DỊCH VỤ
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="dichVuDropdown"
                                style="background-color: #0b3a68;">
                                <li><a class="dropdown-item text-white"
                                        href="{{ route('services.dat-hang-trung-quoc') }}">Dịch vụ đặt hàng Trung
                                        Quốc</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{ route('services.van-chuyen-trung-quoc') }}">Dịch vụ vận chuyển hàng
                                        Trung Quốc</a>
                                </li>
                                <li><a class="dropdown-item text-white" href="{{route('services.danh-gia-hang')}}">Dịch
                                        vụ ghép nhóm đánh hàng</a></li>
                                <li><a class="dropdown-item text-white" href="{{route('services.doi-tien-te')}}">Dịch vụ
                                        chuyển đổi tiền, nạp tiền </a>
                                </li>
                                <li><a class="dropdown-item text-white" href="{{ route('services.gia-tang') }}">Dịch vụ
                                        gia tăng</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" id="banggiaDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                BẢNG GIÁ
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="banggiaDropdown"
                                style="background-color: #0b3a68; ">
                                <li><a class="dropdown-item text-white"
                                        href="{{route('quotations.bang-gia-dich-vu')}}">Bảng giá dịch vụ đặt hàng Trung
                                        Quốc</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('quotations.bang-gia-ky-gui-hang')}}">Bảng giá vận chuyển hàng
                                        Trung Quốc -
                                        Việt Nam</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('quotations.bang-gia-quang-chau')}}">Bảng giá vận
                                        chuyển hàng
                                        Quản Châu -
                                        Việt Nam</a></li>
                                <li><a class="dropdown-item text-white" href="{{route('services.doi-tien-te')}}">Bảng
                                        giá dịch vụ
                                        chuyển tiền</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('tra-cuoc')}}">
                                TRA CƯỚC
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" id="huongdanDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                HƯỚNG DẪN
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="huongdanDropdown"
                                style="background-color: #0b3a68; ">
                                <li><a class="dropdown-item text-white"
                                        href="{{route('instructions.huong-dan-tao-don-hang')}}">Hướng dẫn tạo đặt đơn
                                        hàng</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('instructions.huong-dan-tim-nguon-hang')}}">Hướng dẫn tìm nguồn
                                        hàng trên
                                        Taobao</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('instructions.cong-cu-dat-hang')}}">Hướng dẫn cài đặt công
                                        cụ đặt hàng</a>
                                </li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('instructions.ky-gui-hang-trung-quoc')}}">Hướng dẫn tạo đơn đăng
                                        ký gửi hàng</a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" id="chinhsachDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                CHÍNH SÁCH
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="chinhsachDropdown"
                                style="background-color: #0b3a68; ">
                                <li><a class="dropdown-item text-white" href="{{route('policy.questions')}}">Câu hỏi
                                        thường gặp</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('policy.chinh-sach-khieu-nai')}}">Chính sách khiếu nại</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('policy.quy-dinh-ve-ky-gui-hang')}}">Quy định về hàng ký gửi</a>
                                </li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('policy.chinh-sach-bao-mat')}}">Chính sách bảo mật</a></li>
                                <li><a class="dropdown-item text-white"
                                        href="{{route('policy.cap-nhat-chinh-sach')}}">Thông tin cập nhật chính sách</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('tin-tuc')}}">
                                TIN TỨC
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('su-kien')}}">
                                SỰ KIỆN
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('tuyen-dung')}}">
                                TUYỂN DỤNG
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

    </header>