<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderExtraRequirement extends Model
{
  public $timestamps = false;
    protected $fillable = ['order_id', 'loai_yeu_cau'];
}