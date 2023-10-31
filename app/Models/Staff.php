<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
      'farm_id' ,
      'name' ,
      'phone' ,
      'address' ,
      'image' ,
      'pay_type' , //['hourly','daily','weekly', 'monthly','yearly']
      'status' , //['active', 'deactivate']
      'created_by' ,
      'updated_by' ,
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function staff_payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StaffPayment::class);
    }
}
