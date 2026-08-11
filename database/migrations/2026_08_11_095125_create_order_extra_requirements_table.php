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
Schema::create('order_extra_requirements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
    $table->enum('loai_yeu_cau', ['kiem_hang', 'dong_go', 'khai_thue_gtgt']);
    
    $table->unique(['order_id', 'loai_yeu_cau'], 'uq_order_req');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_extra_requirements');
    }
};