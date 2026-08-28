        <aside class="left-sidebar text-center py-3 d-done d-lg-block">
            <ul class="nav flex-column sidebar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link active"><i class="bi bi-plus-square-dotted"></i><br>TẠO ĐƠN</a>

                    <!-- Menu con (Submenu) bay ra bên phải -->
                    <ul class="submenu list-unstyled shadow-lg">
                        <li><a href="{{ route('order.create') }}"><i class="bi bi-pencil-square me-2 text-warning"></i>
                                Tạo đơn hàng</a></li>
                        <li><a href="{{ route('consignment.create') }}"><i class="bi bi-truck me-2 text-warning"></i>
                                Tạo đơn ký gửi</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-clipboard-minus"></i><br>ĐƠN HÀNG</a>

                    <ul class="submenu list-unstyled shadow-lg">
                        <li><a href="{{ route('list.order') }}"><i class="bi bi-list-check me-2 text-warning"></i> Tất
                                cả đơn hàng</a></li>
                        <li><a href="{{ route('consignment.index') }}"><i
                                    class="bi bi-box-seam-fill me-2 text-warning"></i> Tất cả đơn hàng ký gửi</a>
                        </li>
                    </ul>
                </li>


                <!-- ==== -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-box-seam"></i><br>KIỆN HÀNG</a>

                    <ul class="submenu list-unstyled shadow-lg">
                        <li><a href="{{ route('package.index') }}"><i class="bi bi-list-check me-2 text-warning"></i>
                                Tất cả kiện hàng</a></li>
                        <li><a href="{{ route('delivery.index') }}"><i class="bi bi-truck me-2 text-warning"></i>Giao
                                hàng</a>
                        </li>
                        <li><a href="{{ route('delivery.completed') }}"><i
                                    class="bi bi-calendar2-check me-2 text-warning"></i>Đã giao hàng</a>
                        </li>
                        <li><a href="{{ route('package.inspection') }}"><i
                                    class="bi bi-clipboard2-check me-2 text-warning"></i>Kiểm hàng</a>
                        </li>
                    </ul>
                </li>
                <!-- ==== -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-wallet2"></i><br>TÀI KHOẢN KHÁCH HÀNG</a>

                    <ul class="submenu list-unstyled shadow-lg">
                        <li><a href="{{ route('deposit.instructions') }}"><i
                                    class="bi bi-card-text me-2 text-warning"></i> Hướng dẫn nạp tiền</a></li>
                        <li><a href="{{ route('transaction.index') }}"><i
                                    class="bi bi-clock-history me-2 text-warning"></i>Lịch sử giao dịch</a>
                        </li>
                        <li><a href="{{ route('withdrawal.index') }}"><i
                                    class="bi bi-cash-stack me-2 text-warning"></i>Rút tiền</a>
                        </li>
                    </ul>
                </li>
                <!-- ==== -->
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-emoji-dizzy"></i><br>KHIẾU NẠI</a>

                    <ul class="submenu list-unstyled shadow-lg">
                        <li><a href="{{ route('complaint.index') }}"><i
                                    class="bi bi-list-check me-2 text-warning"></i>Tất cả khiểu nại</a></li>
                        <li><a href="{{ route('package.lost') }}"><i
                                    class="bi bi-clipboard2-x-fill me-2 text-warning"></i>Hàng mất thông tin</a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-person-video"></i><br>NHÀ CUNG CẤP</a>

                    <ul class="submenu list-unstyled shadow-lg">
                        <li><a href="{{ route('supplier.index') }}"><i
                                    class="bi bi-list-check me-2 text-warning"></i>Tất cả nhà cung cấp</a></li>
                        <li><a href="{{ route('supplier.create') }}"><i
                                    class="bi bi-person-plus-fill me-2 text-warning"></i>Thêm nhà cung cấp</a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item mt-4 pt-3 border-top border-secondary">
                    <a href="#" class="nav-link"><i class="bi bi-gear"></i><br>CÀI ĐẶT</a>

                    <ul class="submenu list-unstyled shadow-lg">
                        <li><a href="{{ route('profile.edit') }}"><i class="bi bi-person me-2 text-warning"></i>Thông
                                tin cá nhân</a></li>
                        <li><a href="{{ route('address.index') }}"><i class="bi bi-geo-fill me-2 text-warning"></i>Địa
                                chỉ giao hàng</a>
                        </li>
                        <li><a href="{{ route('password.edit') }}"><i class="bi bi-key-fill me-2 text-warning"></i>Thay
                                đổi mật khẩu</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </aside>