<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dewormer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date',
        'end_date',
        'time',
        'farm_id',
        'cattle_type_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_cost',
        'avg_cost',
        'comment',
        'status',
        'created_by',
        'updated_by',
    ];
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function farm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Farm::class, 'farm_id');
    }
    public function cattle_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CattleType::class, 'cattle_type_id');
    }
    public function cattles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Cattle::class);
    }
}
