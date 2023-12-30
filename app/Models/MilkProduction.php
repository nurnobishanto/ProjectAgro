<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkProduction extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'unique_id',
        'date',
        'cattle_id',
        'farm_id',
        'quantity',
        'note',
        'moment',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function cattle()
    {
        return $this->belongsTo(Cattle::class, 'cattle_id');
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id');
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
