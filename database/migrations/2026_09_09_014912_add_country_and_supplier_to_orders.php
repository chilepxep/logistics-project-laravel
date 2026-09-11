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
   // 1. Thêm vào bảng Đơn mua hộ (có kiểm tra tồn tại)
    Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'country_id')) {
            $table->foreignId('country_id')->nullable()->after('user_id')->constrained('countries')->nullOnDelete();
        }
        if (!Schema::hasColumn('orders', 'supplier_id')) {
            $table->foreignId('supplier_id')->nullable()->after('country_id')->constrained('suppliers')->nullOnDelete();
        }
    });

    // 2. Thêm vào bảng Đơn ký gửi (có kiểm tra tồn tại)
    Schema::table('consignment_orders', function (Blueprint $table) {
        if (!Schema::hasColumn('consignment_orders', 'country_id')) {
            $table->foreignId('country_id')->nullable()->after('user_id')->constrained('countries')->nullOnDelete();
        }
        if (!Schema::hasColumn('consignment_orders', 'supplier_id')) {
            $table->foreignId('supplier_id')->nullable()->after('country_id')->constrained('suppliers')->nullOnDelete();
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};