<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkStock extends Model
{
    use HasFactory;
    protected $fillable = ['farm_id','quantity'];

    public function farm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Farm::class,'farm_id');
    }
}
