    <section class="hero-banner position-relative">

        <!-- Ảnh thả tự do để tự quyết định chiều cao (w-100 giúp ảnh full viền) -->
        <img src="{{ asset('images/banner.png') }}" class="w-100 h-auto d-block" alt="HTKK 360">

        <!-- Lớp nội dung trôi nổi đè lên trên cùng -->
        <div class="content-layer position-absolute top-0 start-0 w-100 d-flex justify-content-center pt-4">

            <!-- Thêm px-3 để thanh search không chạm sát mép viền trên điện thoại -->
            <div class="search-box w-100 mt-2 px-3">
                <form action="#" method="GET">
                    <div class="input-group input-group-lg bg-white rounded-pill overflow-hidden p-1"
                        style="border: 2px solid #ff6a00;">

                        <select class="form-select border-0 shadow-none text-center bg-light" name="platform"
                            style="max-width: 120px; font-weight: 500; font-size: 15px;">
                            <option value="taobao">Taobao</option>
                            <option value="1688">1688</option>
                            <option value="tmall">Tmall</option>
                        </select>

                        <input type="text" name="keyword" class="form-control border-0 shadow-none px-3"
                            placeholder="Nhập tên sản phẩm / link sản phẩm cần tìm..." style="font-size: 15px;">

                        <button class="btn text-white rounded-pill px-4 fw-bold" type="submit"
                            style="background-color: #ff6a00;">
                            <i class="bi bi-search"></i>
                        </button>

                    </div>
                </form>
            </div>

        </div>
    </section>