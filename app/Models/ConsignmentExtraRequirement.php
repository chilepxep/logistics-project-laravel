<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentExtraRequirement extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'consignment_order_id',
        'loai_yeu_cau',
    ];
}