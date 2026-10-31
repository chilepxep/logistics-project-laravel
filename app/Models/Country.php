<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
   protected $fillable = ['ten_quoc_gia', 'ma_quoc_gia', 'tien_te'];

   public function suppliers()
{
    return $this->hasMany(Supplier::class);
}


    public function orders()
    {
        return $this->hasMany(Order::class, 'country_id');
    }

    public function consignmentOrders()
    {
        return $this->hasMany(ConsignmentOrder::class, 'country_id');
    }
}