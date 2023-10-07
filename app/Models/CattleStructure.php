<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CattleStructure extends Model
{
    use HasFactory;
    protected $fillable = [
        'cattle_id',
        'date',
        'images',
        'weight',
        'height',
        'width',
        'health',
        'color',
        'foot',
        'created_by',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function cattle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cattle::class, 'cattle_id');
    }


}
