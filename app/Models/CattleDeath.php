<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CattleDeath extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'date',
        'cattle_id',
        'feeding_expense',
        'other_expense',
        'amount',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];

    public function cattle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cattle::class, 'cattle_id');
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
