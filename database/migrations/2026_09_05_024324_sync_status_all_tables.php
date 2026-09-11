<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        DB::statement("ALTER TABLE orders MODIFY COLUMN trang_thai VARCHAR(50)");
        DB::statement("ALTER TABLE consignment_orders MODIFY COLUMN trang_thai VARCHAR(50)");
        DB::statement("ALTER TABLE packages MODIFY COLUMN tinh_trang VARCHAR(50)");


        
        // Bảng Orders
        DB::table('orders')->where('trang_thai', 'cho_bao_gia')->update(['trang_thai' => 'cho_xu_ly']);
        DB::table('orders')->where('trang_thai', 'can_xac_nhan_lai')->update(['trang_thai' => 'can_lien_he_lai']);
        DB::table('orders')->where('trang_thai', 'da_hoan_thanh')->update(['trang_thai' => 'hoan_thanh']);

        // Bảng Consignment Orders
        DB::table('consignment_orders')->where('trang_thai', 'da_xu_ly')->update(['trang_thai' => 'dang_xu_ly']);

        // Bảng Packages
        DB::table('packages')->where('tinh_trang', 'dang_o_kho_a')->update(['tinh_trang' => 'da_nhap_kho']);
        DB::table('packages')->where('tinh_trang', 'dang_o_kho_b')->update(['tinh_trang' => 'da_nhap_kho']);

        DB::statement("ALTER TABLE orders MODIFY COLUMN trang_thai ENUM('cho_xu_ly', 'dang_xu_ly', 'hoan_thanh', 'da_huy', 'can_lien_he_lai') DEFAULT 'cho_xu_ly'");
        
        DB::statement("ALTER TABLE consignment_orders MODIFY COLUMN trang_thai ENUM('cho_xu_ly', 'dang_xu_ly', 'hoan_thanh', 'da_huy', 'can_lien_he_lai') DEFAULT 'cho_xu_ly'");
        
        DB::statement("ALTER TABLE packages MODIFY COLUMN tinh_trang ENUM('cho_xu_ly', 'xac_nhan_lai', 'da_dat_hang', 'da_nhap_kho', 'dang_van_chuyen', 'dang_giao_hang', 'hoan_thanh', 'da_huy', 'cho_cod') DEFAULT 'cho_xu_ly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};