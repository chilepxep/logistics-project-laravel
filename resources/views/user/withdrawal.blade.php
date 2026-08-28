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




<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0" style="color: #fd7e14;">
            <i class="bi bi-wallet2 me-2"></i> Rút tiền về tài khoản
        </h3>
        <a href="{{ route('transaction.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-clock-history"></i> Lịch sử giao dịch
        </a>
    </div>

    <!-- KHỐI TẠO YÊU CẦU -->
    <div class="row mb-5">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header text-white fw-bold text-uppercase" style="background-color: #fd7e14;">
                    Tạo yêu cầu rút tiền
                </div>
                <div class="card-body p-4">

                    @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('withdrawal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số tiền cần rút (VNĐ) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="so_tien" class="form-control form-control-lg text-danger fw-bold"
                                placeholder="VD: 500000" min="50000" value="{{ old('so_tien') }}" required>
                            <small class="text-muted">Tối thiểu: 50.000 đ</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ngân hàng nhận <span
                                    class="text-danger">*</span></label>
                            <select name="ngan_hang" class="form-select" required>
                                <option value="">-- Chọn ngân hàng hoặc ví điện tử --</option>
                                <option value="Vietcombank" {{ old('ngan_hang') == 'Vietcombank' ? 'selected' : '' }}>
                                    Vietcombank (Ngoại thương VN)</option>
                                <option value="Techcombank" {{ old('ngan_hang') == 'Techcombank' ? 'selected' : '' }}>
                                    Techcombank (Kỹ thương VN)</option>
                                <option value="VietinBank" {{ old('ngan_hang') == 'VietinBank' ? 'selected' : '' }}>
                                    VietinBank (Công thương VN)</option>
                                <option value="BIDV" {{ old('ngan_hang') == 'BIDV' ? 'selected' : '' }}>BIDV (Đầu tư và
                                    Phát triển VN)</option>
                                <option value="Agribank" {{ old('ngan_hang') == 'Agribank' ? 'selected' : '' }}>Agribank
                                    (Nông nghiệp và PTNT VN)</option>
                                <option value="MBBank" {{ old('ngan_hang') == 'MBBank' ? 'selected' : '' }}>MBBank (Quân
                                    đội)</option>
                                <option value="ACB" {{ old('ngan_hang') == 'ACB' ? 'selected' : '' }}>ACB (Á Châu)
                                </option>
                                <option value="Sacombank" {{ old('ngan_hang') == 'Sacombank' ? 'selected' : '' }}>
                                    Sacombank (Sài Gòn Thương Tín)</option>
                                <option value="TPBank" {{ old('ngan_hang') == 'TPBank' ? 'selected' : '' }}>TPBank (Tiên
                                    Phong)</option>
                                <option value="VPBank" {{ old('ngan_hang') == 'VPBank' ? 'selected' : '' }}>VPBank (Việt
                                    Nam Thịnh Vượng)</option>
                                <option value="VIB" {{ old('ngan_hang') == 'VIB' ? 'selected' : '' }}>VIB (Quốc tế)
                                </option>
                                <option value="HDBank" {{ old('ngan_hang') == 'HDBank' ? 'selected' : '' }}>HDBank (Phát
                                    triển TPHCM)</option>
                                <option value="SHB" {{ old('ngan_hang') == 'SHB' ? 'selected' : '' }}>SHB (Sài Gòn - Hà
                                    Nội)</option>
                                <option value="MSB" {{ old('ngan_hang') == 'MSB' ? 'selected' : '' }}>MSB (Hàng Hải)
                                </option>
                                <option value="DongA Bank" {{ old('ngan_hang') == 'DongA Bank' ? 'selected' : '' }}>
                                    DongA Bank (Đông Á)</option>
                                <option value="OCB" {{ old('ngan_hang') == 'OCB' ? 'selected' : '' }}>OCB (Phương Đông)
                                </option>
                                <option value="SeABank" {{ old('ngan_hang') == 'SeABank' ? 'selected' : '' }}>SeABank
                                    (Đông Nam Á)</option>
                                <option value="MoMo" {{ old('ngan_hang') == 'MoMo' ? 'selected' : '' }}>Ví điện tử MoMo
                                </option>
                                <option value="ZaloPay" {{ old('ngan_hang') == 'ZaloPay' ? 'selected' : '' }}>Ví điện tử
                                    ZaloPay</option>
                                <option value="Khác" {{ old('ngan_hang') == 'Khác' ? 'selected' : '' }}>Ngân hàng/Ví
                                    khác...</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Thông tin tài khoản <span
                                    class="text-danger">*</span></label>
                            <textarea name="thong_tin_chuyen_khoan" class="form-control" rows="2"
                                placeholder="Số tài khoản - Tên chủ tài khoản - Chi nhánh (nếu có)"
                                required>{{ old('thong_tin_chuyen_khoan') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-lg w-100 fw-bold text-white shadow-sm"
                            style="background-color: #fd7e14;">
                            GỬI YÊU CẦU RÚT TIỀN
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm border-0 h-100" style="background-color: #fff9f0;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-safe fs-1" style="color: #fd7e14;"></i>
                    </div>
                    <h5 class="text-muted fw-semibold mb-2">Số dư khả dụng hiện tại</h5>
                    <h2 class="fw-bold text-danger mb-4">{{ number_format($soDu, 0, ',', '.') }} VNĐ</h2>

                    <div class="text-start w-100 mt-3 font-14">
                        <p class="fw-bold mb-2"><i class="bi bi-info-circle-fill text-warning me-1"></i> Lưu ý khi rút
                            tiền:</p>
                        <ul class="text-muted">
                            <li class="mb-1">Tên chủ thẻ ngân hàng nhận tiền phải khớp với tên đăng ký tài khoản.</li>
                            <li class="mb-1">Lệnh rút tiền sẽ được bộ phận Kế toán xử lý trong giờ hành chính (8h00 -
                                17h30).</li>
                            <li>Nếu lệnh bị từ chối, số tiền sẽ được hoàn lại vào số dư khả dụng của bạn.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KHỐI LỊCH SỬ RÚT TIỀN -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light fw-bold text-uppercase" style="color: #fd7e14;">
            <i class="bi bi-card-list me-1"></i> Lịch sử yêu cầu rút tiền
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 font-14">
                    <thead class="text-center bg-light">
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 15%;">Ngày Yêu Cầu</th>
                            <th style="width: 15%;">Số Tiền (VNĐ)</th>
                            <th style="width: 15%;">Ngân Hàng</th>
                            <th style="width: 20%;">Thông Tin Nhận</th>
                            <th style="width: 15%;">Ngày Xử Lý</th>
                            <th style="width: 15%;">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawals as $index => $wd)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center text-muted">
                                {{ \Carbon\Carbon::parse($wd->ngay_yeu_cau)->format('d/m/Y H:i') }}</td>
                            <td class="text-center fw-bold text-danger">{{ number_format($wd->so_tien, 0, ',', '.') }}
                            </td>
                            <td class="text-center fw-semibold">{{ $wd->ngan_hang }}</td>
                            <td>{{ $wd->thong_tin_chuyen_khoan }}</td>
                            <td class="text-center text-muted">
                                {{ $wd->ngay_rut ? \Carbon\Carbon::parse($wd->ngay_rut)->format('d/m/Y H:i') : '--' }}
                            </td>
                            <td class="text-center">
                                @switch($wd->tinh_trang)
                                @case('cho_duyet')
                                <span class="badge bg-secondary">Chờ duyệt</span> @break
                                @case('da_duyet')
                                <span class="badge bg-info text-dark">Đã duyệt</span> @break
                                @case('da_chuyen')
                                <span class="badge bg-success">Đã chuyển tiền</span> @break
                                @case('tu_choi')
                                <span class="badge bg-danger">Bị từ chối</span> @break
                                @endswitch
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Bạn chưa có yêu cầu rút tiền nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection