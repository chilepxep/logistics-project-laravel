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
        Schema::table('consignment_orders', function (Blueprint $table) {
            // 1. Thêm cột Chiều vận chuyển (ve_vn: Về Việt Nam, di_qt: Đi Quốc tế)
            if (!Schema::hasColumn('consignment_orders', 'chieu_van_chuyen')) {
                $table->string('chieu_van_chuyen', 10)->default('ve_vn')->after('user_id');
            }

            // 2. Đổi tên cột kho Trung Quốc thành kho Việt Nam cho chuẩn ngữ nghĩa
            if (Schema::hasColumn('consignment_orders', 'kho_nhan_tq_id')) {
                $table->renameColumn('kho_nhan_tq_id', 'kho_vn_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consignment_orders', function (Blueprint $table) {
            // Khôi phục lại trạng thái cũ nếu rollback
            if (Schema::hasColumn('consignment_orders', 'chieu_van_chuyen')) {
                $table->dropColumn('chieu_van_chuyen');
            }
            if (Schema::hasColumn('consignment_orders', 'kho_vn_id')) {
                $table->renameColumn('kho_vn_id', 'kho_nhan_tq_id');
            }
        });
    }
};