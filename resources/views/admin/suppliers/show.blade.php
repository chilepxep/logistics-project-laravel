@extends('layouts.admin')
@section('title', 'Chi tiết Nhà Cung Cấp')
@section('page_title', 'Nhà cung cấp: ' . $supplier->ten_ncc)

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold">Thông tin chi tiết (Mã: {{ $supplier->ma_ncc }})</h6>
        <div>
            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning fw-bold">
                <i class="bi bi-pencil-square"></i> Cập nhật
            </a>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="row g-4">

            <!-- Cột trái: Thông tin cơ bản -->
            <div class="col-lg-7">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-building"></i> 1. Thông tin Tổ chức</h6>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted w-25">Tên NCC:</td>
                        <td class="fw-bold fs-5">{{ $supplier->ten_ncc }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Hình thức:</td>
                        <td>
                            @if($supplier->hinh_thuc == 'online') <span class="badge bg-info text-dark">Online</span>
                            @else <span class="badge bg-secondary">Offline (Xưởng/Chợ)</span> @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Quốc gia:</td>
                        <td class="fw-bold">{{ $supplier->country->ten_quoc_gia ?? '---' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Thành phố/Vị trí:</td>
                        <td>{{ $supplier->thanh_pho ?? '---' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Ngành hàng:</td>
                        <td>{{ $supplier->nganh_hang ?? '---' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Thống kê:</td>
                        <td>
                            Mua hàng: <strong class="text-danger">{{ number_format($supplier->tong_tien_dat_hang) }}
                                đ</strong><br>
                            Khiếu nại: <strong class="text-warning text-dark">{{ $supplier->tong_khieu_nai }}
                                lần</strong>
                        </td>
                    </tr>
                </table>

                <h6 class="fw-bold text-primary mt-4 mb-3"><i class="bi bi-bank"></i> 2. Thông tin Thanh toán</h6>
                <div class="p-3 bg-light rounded border border-light">
                    <p class="mb-1">Ngân hàng: <strong
                            class="text-primary">{{ $supplier->ten_ngan_hang ?? '---' }}</strong></p>
                    <p class="mb-1">Số TK: <strong class="fs-5">{{ $supplier->so_tai_khoan ?? '---' }}</strong></p>
                    <p class="mb-1">Chủ TK: <strong>{{ $supplier->chu_tai_khoan ?? '---' }}</strong></p>
                    <p class="mb-0">Chi nhánh: {{ $supplier->chi_nhanh ?? '---' }}</p>
                </div>
            </div>

            <!-- Cột phải: Danh bạ liên hệ -->
            <div class="col-lg-5">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-lines-fill"></i> 3. Danh bạ Liên hệ</h6>

                @if($supplier->contacts->count() > 0)
                <ul class="list-group shadow-sm">
                    @foreach($supplier->contacts as $contact)
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex align-items-center">
                            <!-- Hiển thị Icon tùy theo loại -->
                            @if($contact->loai == 'wechat') <i class="bi bi-wechat text-success fs-4 me-3"></i>
                            @elseif($contact->loai == 'line') <i class="bi bi-line text-success fs-4 me-3"></i>
                            @elseif($contact->loai == 'whatsapp') <i class="bi bi-whatsapp text-success fs-4 me-3"></i>
                            @elseif($contact->loai == 'telegram') <i class="bi bi-telegram text-info fs-4 me-3"></i>
                            @elseif($contact->loai == 'email') <i class="bi bi-envelope-at text-danger fs-4 me-3"></i>
                            @else <i class="bi bi-telephone text-primary fs-4 me-3"></i>
                            @endif

                            <div>
                                <h6 class="my-0 fw-bold">{{ $contact->gia_tri }}</h6>
                                <small class="text-muted text-uppercase">{{ $contact->loai }}</small>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-light border"
                            onclick="navigator.clipboard.writeText('{{ $contact->gia_tri }}'); alert('Đã copy!');"
                            title="Copy">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="alert alert-secondary">Chưa có thông tin liên hệ nào.</div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection