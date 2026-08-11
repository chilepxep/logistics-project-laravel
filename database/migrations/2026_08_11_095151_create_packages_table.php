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
Schema::create('packages', function (Blueprint $table) {
    $table->id();
    $table->string('ma_van_don', 50);
    $table->string('ma_don_kien_hang', 50)->unique();
    $table->foreignId('order_id')->nullable()->constrained('orders');
    $table->foreignId('consignment_order_id')->nullable()->constrained('consignment_orders');
    $table->enum('tinh_trang', ['cho_xu_ly', 'xac_nhan_lai', 'da_dat_hang', 'dang_o_kho_a', 'dang_o_kho_b', 'dang_giao_hang', 'da_huy', 'cho_cod'])->default('cho_xu_ly');
    $table->string('ghi_chu', 255)->nullable();
    $table->string('loai_hang', 100)->nullable();
    $table->decimal('phi_van_chuyen_noi_dia', 15, 2)->default(0);
    $table->decimal('tong_kg', 10, 2)->nullable();
    $table->decimal('tong_m3', 10, 3)->nullable();
    $table->decimal('phi_khac', 15, 2)->default(0);
    $table->decimal('chiet_khau', 15, 2)->default(0);
    $table->decimal('thanh_tien', 15, 2)->default(0);
    $table->foreignId('tru_so_id')->constrained('warehouses');
    $table->timestamps();
    
    $table->index('tinh_trang');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};