<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'invoice_no',
        'sale_date',
        'party_id',
        'account_id',
        'farm_id',
        'tax',
        'discount',
        'shipping_cost',
        'labor_cost',
        'other_cost',
        'sale_note',
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
    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function saleProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SaleProduct::class);
    }
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
