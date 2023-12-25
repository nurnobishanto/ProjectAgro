<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'name',
        'amount',
        'account_id',
        'status',
        'note',
        'image',
        'created_by',
        'updated_by',
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
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
