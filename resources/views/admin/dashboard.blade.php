@extends('layouts.admin')

@section('title', 'Tổng quan hệ thống')
@section('page_title', 'Tổng quan hệ thống')

@section('content')

<!-- Khối 4 Thẻ Thống Kê -->
<div class="row g-4 mb-4">
    <!-- Doanh thu -->
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 bg-white h-100 p-3 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 font-14 fw-semibold">Doanh Thu Tháng</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['doanh_thu_thang'] ?? 0, 0, ',', '.') }}đ
                    </h4>
                </div>
                <div class="fs-1 text-warning opacity-50"><i class="bi bi-cash-coin"></i></div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng -->
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 bg-white h-100 p-3 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 font-14 fw-semibold">Tổng Đơn Hàng</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['tong_don_hang'] ?? 0) }}</h4>
                </div>
                <div class="fs-1 text-primary opacity-50"><i class="bi bi-cart-check"></i></div>
            </div>
        </div>
    </div>

    <!-- Khách hàng -->
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 bg-white h-100 p-3 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 font-14 fw-semibold">Khách Hàng</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['tong_khach_hang'] ?? 0) }}</h4>
                </div>
                <div class="fs-1 text-success opacity-50"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>

    <!-- Nhân sự -->
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 bg-white h-100 p-3 border-start border-4 border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1 font-14 fw-semibold">Khiếu Nại Chờ</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['tong_khieu_nai'] ?? 0) }}</h4>
                </div>
                <div class="fs-1 text-info opacity-50"><i class="bi bi-emoji-frown"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Khối Biểu Đồ -->
<div class="row g-4">
    <!-- Biểu đồ cột -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom pt-3 pb-2">
                <h6 class="fw-bold m-0 text-dark"><i class="bi bi-bar-chart-line text-primary me-2"></i>Tốc độ tăng
                    trưởng</h6>
            </div>
            <div class="card-body">
                <canvas id="growthChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ tròn -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom pt-3 pb-2">
                <h6 class="fw-bold m-0 text-dark"><i class="bi bi-pie-chart text-danger me-2"></i>Tỉ lệ Khiếu nại</h6>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <canvas id="complaintChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ĐẶT TRÊN CÙNG 1 DÒNG ĐỂ KHÔNG BỊ LỖI FORMAT -->
<script type="application/json" id="chartDataPayload">
@json($chartData ?? [])
</script>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
{
    const rawData = document.getElementById('chartDataPayload').textContent;
    const payload = JSON.parse(rawData);

    // Khởi tạo biểu đồ tăng trưởng
    if (payload.thang) {
        const ctxGrowth = document.getElementById('growthChart').getContext('2d');
        new Chart(ctxGrowth, {
            type: 'bar',
            data: {
                labels: payload.thang,
                datasets: [{
                        label: 'Đơn mua hộ',
                        data: payload.don_hang,
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    },
                    {
                        label: 'Kiện hàng',
                        data: payload.kien_hang,
                        backgroundColor: '#10b981',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Khởi tạo biểu đồ khiếu nại
    if (payload.khieu_nai) {
        const ctxComplaint = document.getElementById('complaintChart').getContext('2d');
        new Chart(ctxComplaint, {
            type: 'doughnut',
            data: {
                labels: ['Chờ xử lý', 'Đang xử lý', 'Hoàn thành'],
                datasets: [{
                    data: Object.values(payload.khieu_nai),
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '70%'
            }
        });
    }
}
</script>
@endpush