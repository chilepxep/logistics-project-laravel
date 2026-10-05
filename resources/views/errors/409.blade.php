<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xung đột dữ liệu - HTKK 360</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
    <div class="text-center p-5 bg-white shadow-sm rounded-4" style="max-width: 500px;">
        <h1 class="display-1 fw-bold mb-0" style="color: #fd7e14;">409</h1>
        <h3 class="mb-3 text-dark fw-bold">Xung đột dữ liệu!</h3>
        <p class="text-muted mb-4" style="line-height: 1.6;">
            Hành động của bạn không thể hoàn thành do dữ liệu này đã bị thay đổi, trùng lặp hoặc đang được hệ thống xử
            lý.<br>
            <strong>Vui lòng quay lại và kiểm tra lại thông tin.</strong>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <button onclick="window.history.back()"
                class="btn btn-warning px-4 py-2 rounded-pill fw-semibold text-white">
                <i class="bi bi-arrow-left me-1"></i> Quay lại trang trước
            </button>
            <a href="{{ url('/') }}" class="btn btn-light px-4 py-2 rounded-pill fw-semibold border">
                Về trang chủ
            </a>
        </div>
    </div>
</body>

</html>