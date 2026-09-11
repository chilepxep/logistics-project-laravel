<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::create([
            'ma_nv'    => 'NV001',
            'ho_ten'   => 'Quản Trị Viên HTKK',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'vai_tro'  => 'admin'
        ]);

         // Nhân viên
        Employee::create([
            'ma_nv'    => 'NV002',
            'ho_ten'   => 'Nguyễn Văn A',
            'email'    => 'nhanvien@gmail.com',
            'password' => Hash::make('123456'),
            'vai_tro'  => 'nhanvien',
        ]);
    }
}