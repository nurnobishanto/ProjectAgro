<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlaughterSale extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'slaughter_sales';
    protected $fillable = [
        'unique_id',
        'date',
        'account_id',
        'slaughter_store_id',
        'slaughter_customer_id',
        'discount',
        'total',
        'paid',
        'due',
        'tax',
        'grand_total',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];
    public function slaughter_customer()
    {
        return $this->belongsTo(SlaughterCustomer::class, 'slaughter_customer_id');
    }
    public function slaughter_store()
    {
        return $this->belongsTo(SlaughterStore::class, 'slaughter_store_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_slaughter_sale')->withPivot('unit_price','quantity','sub_total');

    }

}
