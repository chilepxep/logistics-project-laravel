@extends('layouts.user')

@section('title', 'Tổng quan')

@section('content')


<div class="container-fluid mt-4 px-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-uppercase fw-bold m-0 text-primary">
            <i class="bi bi-geo-alt-fill me-2"></i> Sổ địa chỉ giao hàng
        </h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- CỘT TRÁI: FORM THÊM ĐỊA CHỈ MỚI -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white fw-bold text-uppercase pt-3 pb-2">
                    <i class="bi bi-plus-circle me-1"></i> Thêm địa chỉ mới
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('address.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ và tên người nhận <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="ho_ten" class="form-control" placeholder="VD: Nguyễn Văn A"
                                value="{{ old('ho_ten') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="sdt" class="form-control" placeholder="VD: 0987654321"
                                value="{{ old('sdt') }}" required>
                        </div>
                        <div class="row mb-3 g-2">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Tỉnh / Thành phố <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="tinh_tp" class="form-control" placeholder="VD: Hà Nội"
                                    value="{{ old('tinh_tp') }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Quận / Huyện <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="quan_huyen" class="form-control" placeholder="VD: Cầu Giấy"
                                    value="{{ old('quan_huyen') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ chi tiết <span
                                    class="text-danger">*</span></label>
                            <textarea name="dia_chi_chi_tiet" class="form-control" rows="2"
                                placeholder="Số nhà, Tên đường, Phường/Xã..."
                                required>{{ old('dia_chi_chi_tiet') }}</textarea>
                        </div>
                        <div class="form-check mb-4 mt-2">
                            <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1">
                            <label class="form-check-label text-dark fw-semibold" for="is_default">
                                Đặt làm địa chỉ mặc định
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> LƯU ĐỊA CHỈ
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: DANH SÁCH ĐỊA CHỈ -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100 bg-light">
                <div class="card-body p-3">
                    <h5 class="fw-bold mb-3 text-secondary">Danh sách địa chỉ của bạn</h5>

                    @forelse($addresses as $addr)
                    <div
                        class="card mb-3 border-0 shadow-sm {{ $addr->is_default ? 'border-start border-primary border-4' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="fw-bold fs-5 text-dark">
                                    {{ $addr->ho_ten }}
                                    @if($addr->is_default)
                                    <span class="badge bg-primary ms-2 font-11 align-text-bottom"><i
                                            class="bi bi-check-circle"></i> Mặc định</span>
                                    @endif
                                </div>

                                <!-- Nút thao tác (Xóa / Đặt mặc định) -->
                                <div class="d-flex gap-2">
                                    @if(!$addr->is_default)
                                    <form action="{{ route('address.default', $addr->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-primary"
                                            title="Đặt làm mặc định">
                                            Thiết lập mặc định
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('address.destroy', $addr->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="text-muted font-14 mb-1">
                                <i class="bi bi-telephone-fill me-1 text-secondary"></i> {{ $addr->sdt }}
                            </div>
                            <div class="text-muted font-14">
                                <i class="bi bi-geo-alt-fill me-1 text-secondary"></i> {{ $addr->dia_chi_chi_tiet }},
                                {{ $addr->quan_huyen }}, {{ $addr->tinh_tp }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-map fs-1 d-block mb-3 opacity-50"></i>
                        <p>Bạn chưa thêm địa chỉ nhận hàng nào.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>


@endsection