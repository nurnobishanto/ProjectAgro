<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkWaste extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unique_id',
        'date',
        'farm_id',
        'quantity',
        'unit_price',
        'total',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
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
