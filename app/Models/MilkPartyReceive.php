<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkPartyReceive extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'unique_id',
        'date',
        'account_id',
        'milk_sale_party_id',
        'amount',
        'note',
        'status',
        'type',
        'created_by',
        'updated_by',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function milkSaleParty()
    {
        return $this->belongsTo(MilkSaleParty::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
