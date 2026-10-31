@extends('layouts.admin')
@section('title', 'Quản lý Quốc gia và Tiền tệ')
@section('page_title', 'Danh sách Quốc gia và Tiền tệ')

@section('content')

<div class="container-fluid">
    <!-- Hiển thị thông báo -->
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif

    @php $activeTab = session('active_tab', 'country'); @endphp

    <!-- BỘ TABS ĐIỀU HƯỚNG -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link {{ $activeTab == 'country' ? 'active' : '' }} fw-bold" id="country-tab"
                data-bs-toggle="tab" data-bs-target="#country" type="button">1. Danh sách Quốc gia</button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ $activeTab == 'rate' ? 'active' : '' }} fw-bold" id="rate-tab"
                data-bs-toggle="tab" data-bs-target="#rate" type="button">2. Tỉ giá Tiền tệ</button>
        </li>
    </ul>

    <!-- NỘI DUNG TABS -->
    <div class="tab-content bg-white border border-top-0 p-4 shadow-sm" id="myTabContent">

        <!-- ================= TAB 1: QUỐC GIA ================= -->
        <div class="tab-pane fade {{ $activeTab == 'country' ? 'show active' : '' }}" id="country">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddCountry"><i
                        class="bi bi-plus"></i> Thêm Quốc gia</button>
            </div>

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class=" text-center">
                        <th>Mã QG</th>
                        <th>Tên Quốc Gia</th>
                        <th>Tiền Tệ</th>

                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $c)
                    <tr class=" text-center">
                        <td class="fw-bold">{{ $c->ma_quoc_gia }}</td>
                        <td>{{ $c->ten_quoc_gia }}</td>
                        <td>{{ $c->tien_te }}</td>
                        <td class="text-center">
                            <!-- Nút Edit gọi Modal (dùng JS để fill data) -->
                            <button class="btn btn-sm btn-warning btn-edit-country" data-id="{{ $c->id }}"
                                data-ma="{{ $c->ma_quoc_gia }}" data-ten="{{ $c->ten_quoc_gia }}"
                                data-tiente="{{ $c->tien_te }}">
                                Sửa
                            </button>

                            <form action="{{ route('admin.countries.destroy', $c->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Xoá quốc gia này?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xoá</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- ================= TAB 2: TIỀN TỆ ================= -->
        <div class="tab-pane fade {{ $activeTab == 'rate' ? 'show active' : '' }}" id="rate">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddRate"><i
                        class="bi bi-plus"></i> Thêm Tỉ giá</button>
            </div>

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class=" text-center">
                        <th>Mã Tiền</th>
                        <th>Tên Loại Tiền</th>
                        <th>Tỉ giá (VNĐ)</th>
                        <!-- <th>Mặc định</th> -->
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rates as $r)
                    <tr class=" text-center">
                        <td class="fw-bold text-primary">{{ $r->currency_code }}</td>
                        <td>{{ $r->currency_name }}</td>
                        <td class="fw-bold text-danger">{{ number_format($r->rate) }}đ</td>
                        <!-- <td>
                            @if($r->is_default) <span class="badge bg-success">Mặc định</span> @endif
                        </td> -->
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-edit-rate" data-id="{{ $r->id }}"
                                data-code="{{ $r->currency_code }}" data-name="{{ $r->currency_name }}"
                                data-rate="{{ $r->rate }}" data-default="{{ $r->is_default }}">
                                Sửa
                            </button>

                            <!-- <form action="{{ route('admin.rates.destroy', $r->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Xoá tiền tệ này?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xoá</button>
                            </form> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= CÁC MODALS DÙNG CHUNG ================= -->
<!-- Modal Thêm/Sửa Quốc Gia -->
<div class="modal fade" id="modalCountry" tabindex="-1">
    <div class="modal-dialog">
        <form id="formCountry" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="countryMethod" value="POST">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="titleCountry">Thêm Quốc Gia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Mã QG (VD: VN, CN, US)</label>
                        <input type="text" name="ma_quoc_gia" id="c_ma" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tên Quốc Gia</label>
                        <input type="text" name="ten_quoc_gia" id="c_ten" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Đồng Tiền Tệ (VD: CNY, USD)</label>
                        <input type="text" name="tien_te" id="c_tiente" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu dữ liệu</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Thêm/Sửa Tiền Tệ -->
<div class="modal fade" id="modalRate" tabindex="-1">
    <div class="modal-dialog">
        <form id="formRate" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="rateMethod" value="POST">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="titleRate">Thêm Tiền Tệ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Mã Tiền (VD: CNY, USD)</label>
                        <input type="text" name="currency_code" id="r_code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tên Hiển Thị (VD: Nhân dân tệ)</label>
                        <input type="text" name="currency_name" id="r_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tỉ giá sang VNĐ (VD: 3520)</label>
                        <input type="number" step="0.01" name="rate" id="r_rate" class="form-control" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="r_default">
                        <label class="form-check-label fw-bold text-success">Đặt làm tiền tệ mặc định</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Lưu Tỉ Giá</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // ---- XỬ LÝ MODAL QUỐC GIA ----
    const modalCountry = new bootstrap.Modal(document.getElementById('modalCountry'));
    const formCountry = document.getElementById('formCountry');

    // Nút Thêm QG
    document.querySelector('[data-bs-target="#modalAddCountry"]').addEventListener('click', function() {
        document.getElementById('titleCountry').innerText = 'Thêm Quốc Gia Mới';
        formCountry.action = "{{ route('admin.countries.store') }}";
        document.getElementById('countryMethod').value = 'POST';
        formCountry.reset();
        modalCountry.show();
    });

    // Nút Sửa QG
    document.querySelectorAll('.btn-edit-country').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('titleCountry').innerText = 'Cập Nhật Quốc Gia';
            formCountry.action = `/admin/countries/${this.dataset.id}`;
            document.getElementById('countryMethod').value = 'PUT';

            // Đổ dữ liệu vào input
            document.getElementById('c_ma').value = this.dataset.ma;
            document.getElementById('c_ten').value = this.dataset.ten;
            document.getElementById('c_tiente').value = this.dataset.tiente;
            modalCountry.show();
        });
    });

    // ---- XỬ LÝ MODAL TIỀN TỆ ----
    const modalRate = new bootstrap.Modal(document.getElementById('modalRate'));
    const formRate = document.getElementById('formRate');

    // Nút Thêm Tiền Tệ
    document.querySelector('[data-bs-target="#modalAddRate"]').addEventListener('click', function() {
        document.getElementById('titleRate').innerText = 'Thêm Tiền Tệ Mới';
        formRate.action = "{{ route('admin.rates.store') }}";
        document.getElementById('rateMethod').value = 'POST';
        formRate.reset();
        modalRate.show();
    });

    // Nút Sửa Tiền Tệ
    document.querySelectorAll('.btn-edit-rate').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('titleRate').innerText = 'Cập Nhật Tỉ Giá';
            formRate.action = `/admin/exchange-rates/${this.dataset.id}`;
            document.getElementById('rateMethod').value = 'PUT';

            document.getElementById('r_code').value = this.dataset.code;
            document.getElementById('r_name').value = this.dataset.name;
            document.getElementById('r_rate').value = this.dataset.rate;
            document.getElementById('r_default').checked = (this.dataset.default == "1");
            modalRate.show();
        });
    });
});
</script>
@endsection