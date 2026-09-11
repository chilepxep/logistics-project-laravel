<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
       'ma_tai_khoan',
        'ho_ten',
        'email',
        'password',
        'sdt',
        'ngay_sinh',
        'gioi_tinh',
        'dia_chi',
        'tinh_thanh',
        'loai_van_chuyen_mac_dinh',
        'so_du',
        'is_locked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
           'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'so_du' => 'decimal:2',
            'ngay_sinh' => 'date',
        ];
    }


    public function orders() {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function consignmentOrders() {
        return $this->hasMany(ConsignmentOrder::class, 'user_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function withdrawals() {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }
}