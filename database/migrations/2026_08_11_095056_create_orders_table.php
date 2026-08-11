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
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('ma_don_hang', 30)->unique();
    $table->foreignId('user_id')->constrained('users');
    $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
    $table->foreignId('tru_so_nhan_hang_id')->constrained('warehouses');
    $table->enum('yeu_cau_toc_do', ['nhanh', 'thuong'])->default('thuong');
    $table->enum('trang_thai', ['cho_bao_gia', 'can_xac_nhan_lai', 'da_hoan_thanh', 'da_huy'])->default('cho_bao_gia');
    $table->decimal('tong_tien', 15, 2)->default(0);
    $table->timestamps();
    
    // Đánh Index
    $table->index('user_id');
    $table->index('trang_thai');
    $table->index('created_at');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};