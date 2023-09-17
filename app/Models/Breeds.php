<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Breeds extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cattle_type_id',
        'status',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function cattle_type()
    {
        return $this->belongsTo(CattleType::class, 'cattle_type_id');
    }
}
