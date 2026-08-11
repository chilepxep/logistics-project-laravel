<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('consignment_order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('consignment_order_id')->constrained('consignment_orders')->cascadeOnDelete();
    $table->integer('stt');
    $table->string('hinh_anh_url', 255)->nullable();
    $table->string('ma_van_don', 50)->nullable();
    $table->string('ten_san_pham', 255);
    $table->integer('so_kien_hang')->default(1);
    $table->string('hang_van_chuyen', 100)->nullable();
    $table->string('tq_vn', 50)->nullable();
    $table->string('loai_danh_muc', 100)->nullable();
    $table->integer('so_luong');
    $table->decimal('gia_tri_hang_hoa', 15, 2);
    $table->string('link_san_pham', 500)->nullable();
    $table->text('mo_ta_chi_tiet')->nullable();
    $table->string('ghi_chu', 255)->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_order_items');
    }
};