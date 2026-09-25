<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageTracking extends Model
{
    
use HasFactory;
    protected $fillable = [
        'package_id',
        'warehouse_id',
        'employee_id',
        'title',
        'description',
    ];

    
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

   
    public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id'); 
}
}