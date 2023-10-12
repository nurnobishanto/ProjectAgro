<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'invoice_no',
        'purchase_date',
        'supplier_id',
        'farm_id',
        'tax',
        'discount',
        'shipping_cost',
        'labor_cost',
        'other_cost',
        'purchase_note',
        'image',
        'total',
        'paid',
        'due',
        'grand_total',
        'status',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function products()
    {
        return $this->hasMany(PurchaseProduct::class,'product_id');
    }
}
