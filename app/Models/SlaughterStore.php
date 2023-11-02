<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlaughterStore extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'slaughter_stores';
    protected $fillable = [
        'name',
        'photo',
        'phone',
        'email',
        'address',
        'company',
        'status',
        'created_by',
    ];
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
