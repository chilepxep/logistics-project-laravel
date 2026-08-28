<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $fillable = [
        'user_id', 'ho_ten', 'sdt', 'tinh_tp', 
        'quan_huyen', 'dia_chi_chi_tiet', 'is_default'
    ];

    // Tự động ép kiểu is_default về boolean (true/false)
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}