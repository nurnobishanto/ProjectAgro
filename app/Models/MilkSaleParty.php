<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkSaleParty extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'photo',
        'phone',
        'email',
        'address',
        'company',
        'status',
        'previous_balance',
        'current_balance',
        'created_by',
    ];

    protected $casts = [
        'previous_balance' => 'double',
        'current_balance' => 'double',
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
