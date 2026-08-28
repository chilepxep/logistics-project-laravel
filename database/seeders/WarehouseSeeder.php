<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            // Các kho tại Việt Nam (ID từ 1 đến 4 khớp chuẩn với HTML Form)
            [
                'id' => 1, 
                'ma_kho' => 'VN-HN1', 
                'ten_kho' => 'Kho Hà Nội 1', 
                'loai_kho' => 'VN',
                'dia_chi' => 'Xuân Đỉnh - Bắc Từ Liêm'
            ],
            [
                'id' => 2, 
                'ma_kho' => 'VN-HN2', 
                'ten_kho' => 'Kho Hà Nội 2', 
                'loai_kho' => 'VN',
                'dia_chi' => 'Đường đê san - Đông Anh'
            ],
            [
                'id' => 3, 
                'ma_kho' => 'VN-HP', 
                'ten_kho' => 'Kho Hải Phòng', 
                'loai_kho' => 'VN',
                'dia_chi' => 'Đường Lê Hồng Phong - Hải An'
            ],
            [
                'id' => 4, 
                'ma_kho' => 'VN-HCM', 
                'ten_kho' => 'Kho Hồ Chí Minh', 
                'loai_kho' => 'VN',
                'dia_chi' => 'Phạm Văn Đồng - Quận Thủ Đức'
            ],
            
            // Các kho tại Trung Quốc (Dành cho nghiệp vụ Nhận hàng ký gửi)
            ['id' => 5, 'ma_kho' => 'TQ-BQ', 'ten_kho' => 'Kho Bảo Quan', 'loai_kho' => 'TQ', 'dia_chi' => null],
            ['id' => 6, 'ma_kho' => 'TQ-DH', 'ten_kho' => 'Kho Đông Hưng', 'loai_kho' => 'TQ', 'dia_chi' => null],
            ['id' => 7, 'ma_kho' => 'TQ-QC', 'ten_kho' => 'Kho Quảng Châu', 'loai_kho' => 'TQ', 'dia_chi' => null],
            ['id' => 8, 'ma_kho' => 'TQ-BT', 'ten_kho' => 'Kho Bằng Tường', 'loai_kho' => 'TQ', 'dia_chi' => null],
        ];

        // Dùng lệnh upsert để nếu chạy seed nhiều lần cũng không bị lỗi trùng lặp dữ liệu (Duplicate entry)
        DB::table('warehouses')->upsert($warehouses, ['id'], ['ma_kho', 'ten_kho', 'loai_kho', 'dia_chi']);
    }
}