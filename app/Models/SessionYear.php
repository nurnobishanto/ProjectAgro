<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionYear extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'year',
        'status',
        'created_by',
    ];
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
