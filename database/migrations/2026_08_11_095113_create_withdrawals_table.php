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
Schema::create('withdrawals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users');
    $table->decimal('so_tien', 15, 2);
    $table->string('ngan_hang', 100);
    $table->string('thong_tin_chuyen_khoan', 255);
    $table->dateTime('ngay_yeu_cau')->useCurrent();
    $table->dateTime('ngay_rut')->nullable();
    $table->enum('tinh_trang', ['cho_duyet', 'da_duyet', 'da_chuyen', 'tu_choi'])->default('cho_duyet');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};