<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Supplier;

class CountryAndSupplierSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================
        // 1. TẠO DỮ LIỆU QUỐC GIA
        // =========================================
        $trungQuoc = Country::firstOrCreate(['ma_quoc_gia' => 'CN'], ['ten_quoc_gia' => 'Trung Quốc', 'tien_te' => 'CNY']);
        $nhatBan   = Country::firstOrCreate(['ma_quoc_gia' => 'JP'], ['ten_quoc_gia' => 'Nhật Bản', 'tien_te' => 'JPY']);
        $uc        = Country::firstOrCreate(['ma_quoc_gia' => 'AU'], ['ten_quoc_gia' => 'Úc', 'tien_te' => 'AUD']);
        $duc       = Country::firstOrCreate(['ma_quoc_gia' => 'DE'], ['ten_quoc_gia' => 'Đức', 'tien_te' => 'EUR']);
        $phap      = Country::firstOrCreate(['ma_quoc_gia' => 'FR'], ['ten_quoc_gia' => 'Pháp', 'tien_te' => 'EUR']);

        // =========================================
        // 2. TẠO DỮ LIỆU KHO / NHÀ CUNG CẤP
        // =========================================

        // --- TRUNG QUỐC ---
        $this->createSupplier('NCC_CN_01', 'Kho Tổng Quảng Châu', $trungQuoc->id, 'Quảng Châu', 'offline', 'Tạp hoá, Thời trang', [
            ['loai' => 'wechat', 'gia_tri' => 'gz_warehouse_888'],
            ['loai' => 'sdt', 'gia_tri' => '+86 138 0013 8000']
        ]);
        $this->createSupplier('NCC_CN_02', 'Kho Trung chuyển Thâm Quyến', $trungQuoc->id, 'Thâm Quyến', 'online', 'Điện tử, Phụ kiện', [
            ['loai' => 'wechat', 'gia_tri' => 'sz_tech_hub'],
            ['loai' => 'email', 'gia_tri' => 'shenzhen@logistics.cn']
        ]);

        // --- NHẬT BẢN ---
        $this->createSupplier('NCC_JP_01', 'Đại lý Tokyo Hub', $nhatBan->id, 'Tokyo', 'online', 'Mỹ phẩm, TPCN', [
            ['loai' => 'line', 'gia_tri' => 'tokyo_hub_jp'],
            ['loai' => 'sdt', 'gia_tri' => '+81 90 1234 5678']
        ]);
        $this->createSupplier('NCC_JP_02', 'Kho Osaka Express', $nhatBan->id, 'Osaka', 'offline', 'Hàng tiêu dùng, Đồ gia dụng', [
            ['loai' => 'line', 'gia_tri' => 'osaka_express_99'],
            ['loai' => 'email', 'gia_tri' => 'contact@osaka-express.jp']
        ]);

        // --- ÚC ---
        $this->createSupplier('NCC_AU_01', 'Sydney Global Export', $uc->id, 'Sydney', 'online', 'Sữa, Thực phẩm', [
            ['loai' => 'whatsapp', 'gia_tri' => '+61 4 1234 5678']
        ]);
        $this->createSupplier('NCC_AU_02', 'Melbourne DropShip', $uc->id, 'Melbourne', 'online', 'Hàng tiêu dùng', [
            ['loai' => 'telegram', 'gia_tri' => '@melbourne_drop'],
            ['loai' => 'email', 'gia_tri' => 'sales@melbournedropship.com.au']
        ]);

        // --- ĐỨC ---
        $this->createSupplier('NCC_DE_01', 'Berlin Euro Hub', $duc->id, 'Berlin', 'offline', 'Phụ tùng, Máy móc', [
            ['loai' => 'whatsapp', 'gia_tri' => '+49 151 1234 5678'],
            ['loai' => 'email', 'gia_tri' => 'berlin.hub@euro-logistics.de']
        ]);
        $this->createSupplier('NCC_DE_02', 'Frankfurt Transit', $duc->id, 'Frankfurt', 'online', 'Hàng xách tay', [
            ['loai' => 'telegram', 'gia_tri' => '@frankfurt_transit']
        ]);

        // --- PHÁP ---
        $this->createSupplier('NCC_FR_01', 'Paris Central Warehouse', $phap->id, 'Paris', 'offline', 'Nước hoa, Thời trang cao cấp', [
            ['loai' => 'whatsapp', 'gia_tri' => '+33 6 12 34 56 78'],
            ['loai' => 'email', 'gia_tri' => 'paris@france-export.fr']
        ]);
        $this->createSupplier('NCC_FR_02', 'Lyon Distribution Center', $phap->id, 'Lyon', 'online', 'Dược mỹ phẩm', [
            ['loai' => 'sdt', 'gia_tri' => '+33 4 12 34 56 78']
        ]);
    }

    /**
     * Hàm hỗ trợ tạo Nhà cung cấp & Liên hệ nhanh gọn
     */
    private function createSupplier($maNcc, $tenNcc, $countryId, $thanhPho, $hinhThuc, $nganhHang, $contacts = [])
    {
        $supplier = Supplier::firstOrCreate(
            ['ma_ncc' => $maNcc],
            [
                'ten_ncc'    => $tenNcc,
                'country_id' => $countryId,
                'thanh_pho'  => $thanhPho,
                'hinh_thuc'  => $hinhThuc,
                'nganh_hang' => $nganhHang,
            ]
        );

        // Nếu nhà cung cấp này chưa có liên hệ nào thì mới thêm mới
        if ($supplier->contacts()->count() == 0) {
            foreach ($contacts as $contact) {
                $supplier->contacts()->create($contact);
            }
        }
    }
}