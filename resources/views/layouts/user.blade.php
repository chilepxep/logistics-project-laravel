<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý cá nhân') - HTKK 360</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
    @vite(['resources/css/dashboard.css'])

    <style>
    .zalo-floating-button {
        position: fixed;
        bottom: 20px;
        /* Cách mép dưới 20px */
        right: 30px;
        /* Cách mép phải 20px */
        width: 60px;
        height: 60px;
        z-index: 9999;
        /* Đảm bảo nút luôn nổi lên trên cùng */
        transition: transform 0.3s ease;
    }

    .zalo-floating-button img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .zalo-floating-button:hover {
        transform: scale(1.1);
        /* Phóng to nhẹ khi di chuột */
    }

    .fb-floating-button {
        position: fixed;
        bottom: 90px;
        /* Nằm cao hơn nút Zalo 70px để không bị đè */
        right: 30px;
        width: 60px;
        height: 60px;
        z-index: 9999;
        transition: transform 0.3s ease;
    }

    .fb-floating-button img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .fb-floating-button:hover {
        transform: scale(1.1);
    }
    </style>
</head>

<body class="dashboard-body">

    <!-- Gọi Topbar vào đây -->
    @include('user.partials.topbar')

    <!-- MAIN LAYOUT -->
    <div class="d-flex main-wrapper">

        <!-- Gọi Sidebar vào đây -->
        @include('user.partials.sidebar')

        <!-- NỘI DUNG CHÍNH (Thay đổi theo từng trang) -->
        <main class="flex-grow-1 bg-light center-content">
            @yield('content')
        </main>

        <!-- SIDEBAR PHẢI (Nếu trang nào cần thì gọi yield, không thì thôi) -->
        @yield('right_sidebar')


    </div>

    <!-- Modal Chi tiết thông báo -->
    <div class="modal fade" id="modalNotificationDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light border-bottom-0">
                    <h5 class="modal-title fw-bold" id="modalNotiTitle" style="color: #0b3a68;">Chi tiết thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Nội dung HTML sinh ra từ TinyMCE sẽ được JavaScript đẩy vào đây -->
                <div class="modal-body p-4" id="modalNotiBody" style="font-size: 15px; line-height: 1.6;">
                </div>
            </div>
        </div>
    </div>



    <a href="zalo://conversation?phone=0333661149" class="zalo-floating-button">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg?utm_source=vi.wikipedia.org&utm_campaign=index&utm_content=original"
            alt="Chat Zalo">
    </a>

    <a href="https://m.me/61560371098779" target="_blank" class="fb-floating-button">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png?utm_source=vi.wikipedia.org&utm_campaign=index&utm_content=original"
            alt="Chat Facebook">
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
    const notiModal = new bootstrap.Modal(document.getElementById('modalNotificationDetail'));

    // Hàm nhận 3 tham số: Thẻ HTML vừa bấm, ID thông báo, và ID của cục báo đỏ trên Tab
    function openNotification(element, id, tabBadgeId) {

        // 1. Lấy dữ liệu và hiện Popup
        let title = element.querySelector('.notif-text').innerText;
        let contentHtml = document.getElementById('noti-content-' + id).innerHTML;

        document.getElementById('modalNotiTitle').innerText = title;
        document.getElementById('modalNotiBody').innerHTML = contentHtml;
        notiModal.show();

        // 2. Xử lý logic Đánh dấu đã đọc (chỉ chạy nếu nó có class 'unread')
        if (element.classList.contains('unread')) {
            fetch(`/notifications/read/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Bỏ in đậm
                        element.classList.remove('unread');

                        // Hàm phụ: Giảm trừ số hiển thị
                        function decrementBadge(badgeId) {
                            let badge = document.getElementById(badgeId);
                            if (badge) {
                                let count = parseInt(badge.innerText);
                                if (count > 0) {
                                    count--;
                                    badge.innerText = count;
                                    if (count === 0) badge.style.display = 'none';
                                }
                            }
                        }

                        // Giảm số ở chuông tổng (Ngoài cùng)
                        decrementBadge('global-noti-badge');

                        // Giảm số ở Tab hiện tại (Ngôi sao hoặc Tài chính)
                        decrementBadge(tabBadgeId);
                    }
                }).catch(error => console.error('Error:', error));
        }
    }

    // Hàm xử lý khi bấm nút "Đánh dấu tất cả"
    window.markAllNotificationsRead = function() {
        fetch(`/notifications/read-all`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 1. Xóa class 'unread' ở TẤT CẢ các thẻ chứa thông báo (Mất in đậm)
                    document.querySelectorAll('.notif-item.unread').forEach(function(item) {
                        item.classList.remove('unread');
                    });

                    // 2. Ép tất cả các cục đỏ đếm số về 0 và Ẩn đi
                    const badgeIds = ['global-noti-badge', 'badge-system', 'badge-promo', 'badge-money'];

                    badgeIds.forEach(function(id) {
                        let badge = document.getElementById(id);
                        if (badge) {
                            badge.innerText = '0';

                        }
                    });
                }
            }).catch(error => console.error('Error:', error));
    };
    </script>


</body>



</html>