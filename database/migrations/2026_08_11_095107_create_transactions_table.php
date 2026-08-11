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
Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users');
    $table->dateTime('thoi_gian')->useCurrent();
    $table->enum('loai_giao_dich', ['nap_tien', 'rut_tien', 'dat_hang', 'thanh_toan', 'hoan_tien']);
    $table->string('thong_tin', 255)->nullable();
    $table->decimal('gia_tri_giao_dich', 15, 2);
    $table->decimal('so_du_hien_tai', 15, 2);
    
    $table->index(['user_id', 'thoi_gian']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};