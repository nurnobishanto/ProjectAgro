<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'code',
        'type',
        'unit_id',
        'purchase_price',
        'sale_price',
        'alert_quantity',
        'description',
        'image',
        'status',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
