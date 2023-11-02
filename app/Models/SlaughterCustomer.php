<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlaughterCustomer extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'slaughter_customers';
    protected $fillable = [
        'name',
        'photo',
        'phone',
        'email',
        'address',
        'company',
        'balance',
        'status',
        'created_by',
    ];
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
