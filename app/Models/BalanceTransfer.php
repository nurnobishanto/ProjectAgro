<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BalanceTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unique_id',
        'date',
        'from_account_id',
        'to_account_id',
        'amount',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];

    public function fromAccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class,'from_account_id');
    }
    public function toAccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class,'to_account_id');
    }
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
