<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedCost extends Model
{
    use HasFactory;
    protected $fillable = ['date','model', 'model_id', 'amount'];
    public function model()
    {
        return $this->morphTo();
    }
}
