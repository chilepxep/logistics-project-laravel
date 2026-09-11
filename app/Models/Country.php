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
}