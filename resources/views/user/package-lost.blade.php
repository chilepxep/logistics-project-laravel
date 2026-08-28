@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')

<div
    class="top-banner mb-4 p-4 rounded-4 shadow-sm bg-white d-flex flex-wrap align-items-center justify-content-between">
    <!-- Hotline -->
    <div class="d-flex align-items-center me-3 mb-3 mb-md-0">
        <i class="bi bi-headset text-primary fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">HOTLINE</small>
            <h5 class="text-danger fw-bold mb-0">024.6680.3049</h5>
        </div>
    </div>

    <!-- Thanh tìm kiếm Taobao -->
    <div class="flex-grow-1 mx-md-4 mb-3 mb-md-0" style="max-width: 500px;">
        <div class="input-group shadow-sm rounded-pill overflow-hidden border">
            <span class="input-group-text bg-white border-0 text-danger fw-bold">Taobao</span>
            <input type="text" class="form-control border-0 shadow-none font-14"
                placeholder="Nhập từ khóa tìm kiếm (Tiếng Việt)...">
            <button class="btn text-white px-4" type="button" style="background-color: #ff6a00;"><i
                    class="bi bi-search"></i></button>
        </div>
    </div>

    <!-- Tỉ giá -->
    <div class="d-flex align-items-center text-end">
        <i class="bi bi-cash-coin text-warning fs-1 me-2"></i>
        <div>
            <small class="text-muted fw-bold">TỈ GIÁ</small>
            <h5 class="text-danger fw-bold mb-0">3,520 đ</h5>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> <strong>Thành công!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Lỗi!</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="container-fluid mt-4 px-4 pb-5">
    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-uppercase fw-bold m-0" style="color: #17a2b8;">
                <i class="bi bi-box-seam me-2"></i> Hàng mất thông tin
            </h3>
            <p class="text-muted mt-1 mb-0 font-14">Danh sách các kiện hàng đã về kho nhưng chưa xác định được chủ nhân.
            </p>
        </div>
    </div>

    <!-- KHỐI TÌM KIẾM MÃ VẬN ĐƠN -->
    <div class="card shadow-sm border-0 mb-4" style="background-color: #e0f7fa;">
        <div class="card-body p-4 text-center">
            <h5 class="fw-bold mb-3 text-dark">Bạn quên khai báo mã vận đơn? Hãy tìm kiếm tại đây!</h5>
            <form action="{{ route('package.lost') }}" method="GET" class="row justify-content-center g-2">
                <div class="col-md-5">
                    <input type="text" name="ma_van_don" class="form-control form-control-lg border-info"
                        placeholder="Nhập mã vận đơn (Tracking)..." value="{{ request('ma_van_don') }}">
                </div>
                <div class="col-md-3">
                    <select name="tru_so_id" class="form-select form-select-lg border-info">
                        <option value="">-- Tất cả kho nhận --</option>
                        @foreach($warehouses as $kho)
                        <option value="{{ $kho->id }}" {{ request('tru_so_id') == $kho->id ? 'selected' : '' }}>
                            {{ $kho->ten_kho }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-lg w-100 text-white fw-bold shadow-sm"
                        style="background-color: #17a2b8;">
                        <i class="bi bi-search"></i> TÌM KIẾM
                    </button>
                </div>
            </form>
            @if(request()->has('ma_van_don') || request()->has('tru_so_id'))
            <div class="mt-3">
                <a href="{{ route('package.lost') }}" class="text-danger text-decoration-underline font-14"><i
                        class="bi bi-x-circle"></i> Xóa bộ lọc</a>
            </div>
            @endif
        </div>
    </div>

    <!-- BẢNG DANH SÁCH HÀNG MẤT THÔNG TIN -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="text-center text-white" style="background-color: #17a2b8;">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 25%;">Mã Vận Đơn</th>
                            <th style="width: 15%;">Kho Đang Lưu Giữ</th>
                            <th style="width: 15%;">Cân Nặng / Kích Thước</th>
                            <th style="width: 20%;">Ngày Nhập Kho</th>
                            <th style="width: 20%;">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $index => $pkg)
                        <tr>
                            <td class="text-center fw-bold">
                                {{ ($packages->currentPage() - 1) * $packages->perPage() + $index + 1 }}</td>

                            <td class="text-center">
                                <div class="fw-bold fs-6 text-danger">{{ $pkg->ma_van_don }}</div>
                                <div class="text-muted font-12">Mã kiện: {{ $pkg->ma_don_kien_hang }}</div>
                            </td>

                            <td class="text-center fw-semibold">
                                <i class="bi bi-building text-info"></i> {{ $pkg->khoNhan->ten_kho ?? 'Đang cập nhật' }}
                            </td>

                            <td class="text-center">
                                <div><span class="fw-bold">{{ $pkg->tong_kg ?? 0 }}</span> kg</div>
                                <div class="text-muted"><span class="fw-bold">{{ $pkg->tong_m3 ?? 0 }}</span> m³</div>
                            </td>

                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($pkg->created_at)->format('d/m/Y H:i') }}
                            </td>

                            <td class="text-center">
                                <!-- Nút bấm gọi hàm JS xác nhận -->
                                <button onclick="claimPackage('{{ $pkg->ma_van_don }}')"
                                    class="btn btn-sm text-white fw-semibold" style="background-color: #17a2b8;">
                                    <i class="bi bi-hand-index-thumb"></i> Nhận kiện này
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-1 d-block mb-3" style="color: #17a2b8;"></i>
                                <h5>Tuyệt vời!</h5>
                                <p>Hiện tại không có kiện hàng nào mất thông tin.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Phân trang -->
        @if($packages->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3">
            {{ $packages->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function claimPackage(maVanDon) {
    Swal.fire({
        title: 'Xác nhận kiện hàng',
        html: `
                <div class="text-start font-15 text-muted mb-3">
                    Để nhận lại kiện hàng có mã vận đơn <strong class="text-danger">${maVanDon}</strong>, bạn cần làm theo các bước sau:
                </div>
                <ol class="text-start font-14">
                    <li class="mb-2">Chụp màn hình đơn mua hàng trên Taobao/1688 có chứa mã vận đơn này.</li>
                    <li class="mb-2">Gửi hình ảnh cho bộ phận CSKH qua Zalo hoặc Fanpage.</li>
                    <li>Sau khi xác minh, nhân viên sẽ tự động gắn kiện hàng vào tài khoản của bạn.</li>
                </ol>
            `,
        icon: 'info',
        iconColor: '#17a2b8',
        showCancelButton: true,
        confirmButtonText: 'Liên hệ CSKH ngay',
        cancelButtonText: 'Đóng',
        confirmButtonColor: '#17a2b8',
    }).then((result) => {
        if (result.isConfirmed) {
            // Thay link Zalo/Facebook bằng link thực tế của bạn
            window.open('https://zalo.me/sdt_cua_ban', '_blank');
        }
    });
}
</script>


@endsection