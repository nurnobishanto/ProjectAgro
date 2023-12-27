<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedingCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','status','created_by','updated_by'];
    public function cattle()
    {
        return $this->belongsToMany(Cattle::class, 'feeding_category_cattle');
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
