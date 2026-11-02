   <style>
/* Tùy chỉnh thanh cuộn cho khu vực thông báo */
.notif-content::-webkit-scrollbar {
    width: 5px;
    /* Làm thanh cuộn mỏng lại */
}

.notif-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.notif-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.notif-content::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
   </style>

   <nav class="navbar navbar-expand-lg top-navbar px-3 shadow-sm" style="background-color: #0b3a68;">
       <div class="container-fluid">

           <!-- Logo -->
           <a href="{{ route('homepage') }}" class="navbar-brand">
               <img src="{{ asset('images/logo_3.png') }}" class="img-fluid logo" alt="HTKK 360">
           </a>

           <!-- Button mobile -->
           <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
               data-bs-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false"
               aria-label="Toggle navigation">
               <i class="bi bi-list text-white fs-2"></i>
           </button>

           <!-- Menu -->
           <div class="collapse navbar-collapse" id="userNavbar">

               <div class="d-flex align-items-center text-white font-14 ms-auto user-menu">

                   <!-- Số dư -->
                   <span class="me-4 balance">
                       Số dư:
                       <strong class="text-warning fs-6">
                           {{ number_format(Auth::user()->so_du ?? 0, 0, ',', '.') }}đ
                       </strong>
                       <i class="bi bi-wallet2 text-warning ms-1"></i>
                   </span>

                   <!-- Giỏ hàng -->
                   <a href="{{ route('order.all') }}"
                       class="text-white text-decoration-none me-3 position-relative nav-icon">
                       <i class="bi bi-cart3 fs-5"></i>

                       <!-- Chỉ hiển thị số lượng khi người dùng đã đăng nhập -->
                       @auth
                       @php
                       $userId = Auth::id();

                       // Đếm tổng số kiện hàng thuộc về Đơn mua hộ HOẶC Đơn ký gửi của user này
                       $tongDon = \App\Models\Package::whereHas('order', function ($query) use ($userId) {
                       $query->where('user_id', $userId);
                       })->orWhereHas('consignmentOrder', function ($query) use ($userId) {
                       $query->where('user_id', $userId);
                       })->count();
                       @endphp

                       <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                           {{ $tongDon > 99 ? '99+' : $tongDon }}
                       </span>
                       @else
                       <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                           0
                       </span>
                       @endauth
                   </a>
                   <!-- Email -->
                   <a href="{{ route('feedback.index') }}" class="text-white text-decoration-none me-3 nav-icon">
                       <i class="bi bi-envelope fs-5"></i>
                   </a>

                   <!-- Nút chuông thông báo -->
                   @php
                   // 1. Tab Hệ thống
                   $systemNotis = $globalNotifications->where('type', 'system');
                   $unreadSystem = $systemNotis->where('is_read', false)->count();

                   // 2. Tab Khuyến mãi
                   $promoNotis = $globalNotifications->where('type', 'promotion');
                   $unreadPromo = $promoNotis->where('is_read', false)->count();

                   // 3. Tab Tài chính
                   $financeNotis = $globalNotifications->where('type', 'price');
                   $unreadFinance = $financeNotis->where('is_read', false)->count();
                   @endphp

                   <!-- Nút chuông thông báo -->
                   <div class="dropdown">
                       <a href="#" class="text-white text-decoration-none me-3 position-relative nav-icon"
                           id="bellDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                           data-bs-auto-close="outside">
                           <i class="bi bi-bell fs-5"></i>
                           <!-- Tổng số thông báo chưa đọc -->
                           <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                               id="global-noti-badge"
                               style="display: '{{ $unreadCount > 0 ? 'inline-block' : 'none' }};'">
                               {{ $unreadCount }}
                           </span>
                       </a>

                       <!-- Khối Dropdown Menu -->
                       <div class="dropdown-menu dropdown-menu-end border-0 notif-dropdown"
                           aria-labelledby="bellDropdown">
                           <!-- Header -->
                           <div class="bg-white text-center fw-bold py-2 border-bottom font-14" style="color: #0b3a68;">
                               THÔNG BÁO MỚI
                           </div>

                           <!-- Body: Chia 2 cột -->
                           <div class="d-flex">
                               <!-- Cột trái: Sidebar Tabs -->
                               <div class="nav flex-column notif-sidebar" id="notif-tabs" role="tablist"
                                   aria-orientation="vertical">
                                   <!-- Tab 1: Hệ thống (Dùng icon cái loa hoặc chuông) -->
                                   <button class="nav-link active position-relative" data-bs-toggle="pill"
                                       data-bs-target="#notif-system" type="button" role="tab">
                                       <i class="bi bi-megaphone"></i>
                                       <span class="badge bg-danger rounded-pill badge-count text-white"
                                           id="badge-system"
                                           style="display: '@if($unreadSystem > 0) inline-block @else none @endif;'">
                                           {{ $unreadSystem }}
                                       </span>
                                   </button>

                                   <!-- Tab 2: Khuyến mãi (Ngôi sao) -->
                                   <button class="nav-link position-relative" data-bs-toggle="pill"
                                       data-bs-target="#notif-promo" type="button" role="tab">
                                       <i class="bi bi-star"></i>
                                       <span class="badge bg-danger rounded-pill badge-count text-white"
                                           id="badge-promo"
                                           style="display:' @if($unreadPromo > 0) inline-block @else none @endif;'">
                                           {{ $unreadPromo }}
                                       </span>
                                   </button>

                                   <!-- Tab 3: Tài chính ($) -->
                                   <button class="nav-link position-relative" data-bs-toggle="pill"
                                       data-bs-target="#notif-money" type="button" role="tab">
                                       <i class="bi bi-currency-dollar"></i>
                                       <span class="badge bg-danger rounded-pill badge-count text-white"
                                           id="badge-money"
                                           style='display: "@if($unreadFinance > 0) inline-block @else none @endif;"'>
                                           {{ $unreadFinance }}
                                       </span>
                                   </button>
                                   <!-- Tab 3, 4, 5 -->
                                   <!-- <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notif-box"
                                        type="button" role="tab"><i class="bi bi-box-seam"></i></button> -->
                                   <!--<button class="nav-link" data-bs-toggle="pill" data-bs-target="#notif-sad"
                                        type="button" role="tab"><i class="bi bi-emoji-frown"></i></button> -->
                                   <button class="nav-link border-bottom-0" data-bs-toggle="pill"
                                       data-bs-target="#notif-chat" type="button" role="tab"><i
                                           class="bi bi-chat-dots"></i></button>
                               </div>

                               <!-- Cột phải: Nội dung Thông báo -->
                               <div class="tab-content flex-grow-1 notif-content" id="notif-tabContent"
                                   style="max-height: 400px; overflow-y: auto;">

                                   <!-- NỘI DUNG TAB 1: HỆ THỐNG -->
                                   <div class="tab-pane fade show active" id="notif-system" role="tabpanel">
                                       @forelse($systemNotis as $noti)
                                       <a href="javascript:void(0)"
                                           class="text-decoration-none d-block notif-item {{ $noti->is_read ? '' : 'unread' }}"
                                           onclick="window.openNotification(this, '{{ $noti->id }}', 'badge-system')">
                                           <div class="notif-text">{{ $noti->title }}</div>
                                           <div class="notif-time"><i class="bi bi-clock me-1"></i>
                                               {{ $noti->created_at->diffForHumans() }}</div>
                                           <div id="noti-content-{{ $noti->id }}" class="d-none">{!! $noti->content !!}
                                           </div>
                                       </a>
                                       @empty
                                       <div class="text-center p-4 text-muted mt-4"><i
                                               class="bi bi-megaphone fs-1 opacity-50 d-block mb-2"></i>Chưa có thông
                                           báo hệ thống.</div>
                                       @endforelse
                                   </div>

                                   <!-- NỘI DUNG TAB 2: KHUYẾN MÃI -->
                                   <div class="tab-pane fade" id="notif-promo" role="tabpanel">
                                       @forelse($promoNotis as $noti)
                                       <a href="javascript:void(0)"
                                           class="text-decoration-none d-block notif-item {{ $noti->is_read ? '' : 'unread' }}"
                                           onclick="window.openNotification(this, '{{ $noti->id }}', 'badge-promo')">
                                           <div class="notif-text">{{ $noti->title }}</div>
                                           <div class="notif-time"><i class="bi bi-clock me-1"></i>
                                               {{ $noti->created_at->diffForHumans() }}</div>
                                           <div id="noti-content-{{ $noti->id }}" class="d-none">{!! $noti->content !!}
                                           </div>
                                       </a>
                                       @empty
                                       <div class="text-center p-4 text-muted mt-4"><i
                                               class="bi bi-star fs-1 opacity-50 d-block mb-2"></i>Chưa có khuyến mãi.
                                       </div>
                                       @endforelse
                                   </div>

                                   <!-- NỘI DUNG TAB 3: TÀI CHÍNH -->
                                   <div class="tab-pane fade" id="notif-money" role="tabpanel">
                                       @forelse($financeNotis as $noti)
                                       <a href="javascript:void(0)"
                                           class="text-decoration-none d-block notif-item {{ $noti->is_read ? '' : 'unread' }}"
                                           onclick="window.openNotification(this, '{{ $noti->id }}', 'badge-money')">
                                           <div class="notif-text">{{ $noti->title }}</div>
                                           <div class="notif-time"><i class="bi bi-clock me-1"></i>
                                               {{ $noti->created_at->diffForHumans() }}</div>
                                           <div id="noti-content-{{ $noti->id }}" class="d-none">{!! $noti->content !!}
                                           </div>
                                       </a>
                                       @empty
                                       <div class="text-center p-4 text-muted mt-4"><i
                                               class="bi bi-wallet2 fs-1 opacity-50 d-block mb-2"></i>Chưa có biến động
                                           số dư.</div>
                                       @endforelse
                                   </div>

                                   <!-- CÁC TAB CÒN LẠI (Trống) -->
                                   <div class="tab-pane fade" id="notif-chat" role="tabpanel">
                                       <div class="text-center p-4 text-muted mt-4"><i
                                               class="bi bi-chat-dots fs-1 d-block mb-2 opacity-50"></i>Chưa có tin
                                           nhắn mới.</div>
                                   </div>
                               </div>
                           </div>

                           <!-- Footer -->
                           <div class="bg-light text-center border-top p-2">
                               <a href="javascript:void(0)" onclick="window.markAllNotificationsRead()"
                                   class="text-decoration-none fw-bold" style="color: #0b3a68; font-size: 14px;">
                                   <i class="bi bi-check2-all me-1"></i> Đánh dấu đã đọc tất cả
                               </a>
                           </div>
                       </div>
                   </div>

                   <!-- Avatar -->
                   <div class="dropdown">

                       <a href="#" class="d-block link-light text-decoration-none dropdown-toggle"
                           data-bs-toggle="dropdown" aria-expanded="false">

                           <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->ho_ten ?? 'User') }}&background=ff6a00&color=fff"
                               alt="Avatar" width="36" height="36" class="rounded-circle">
                       </a>

                       <ul class="dropdown-menu dropdown-menu-end shadow">

                           <li>
                               <a href="{{ route('profile.edit') }}" class="dropdown-item" href="#">
                                   <i class="bi bi-person me-2"></i>
                                   Hồ sơ
                               </a>
                           </li>

                           <li>
                               <hr class="dropdown-divider">
                           </li>

                           <li>
                               <form action="{{ route('logout') }}" method="POST">
                                   @csrf

                                   <button type="submit" class="dropdown-item text-danger">
                                       <i class="bi bi-box-arrow-right me-2"></i>
                                       Đăng xuất
                                   </button>
                               </form>
                           </li>

                       </ul>

                   </div>

               </div>

           </div>

       </div>
   </nav>