<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đã hết hạn phiên làm việc - HTKK 360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
    <div class="text-center p-5 bg-white shadow-sm rounded-4" style="max-width: 500px;">
        <h1 class="display-1 fw-bold mb-0" style="color: #0b3a68;">419</h1>
        <h3 class="mb-3 text-dark fw-bold">Phiên làm việc đã hết hạn</h3>
        <p class="text-muted mb-4" style="line-height: 1.6;">
            Vì lý do bảo mật, hệ thống đã ngắt kết nối do bạn đã treo máy quá lâu hoặc có thay đổi đăng nhập ở nhiều cửa
            sổ
            khác.<br>
            <strong>Vui lòng tải lại trang để tiếp tục thao tác!</strong>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <button onclick="window.location.reload()" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold"
                style="background-color: #0b3a68; border: none;">
                <i class="bi bi-arrow-clockwise me-1"></i> Tải lại trang
            </button>
            <a href="{{ url('/') }}" class="btn btn-light px-4 py-2 rounded-pill fw-semibold border">
                Về trang chủ
            </a>
        </div>
    </div>
</body>

</html>