<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'admin_id',
        'bank_name',
        'account_name',
        'account_no',
        'account_type',
        'previous_balance',
        'current_balance',
        'status',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
