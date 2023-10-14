<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedingGroup extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['farm_id', 'feeding_category_id','cattle_type_id', 'feeding_moment_id','status','created_by','updated_by'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'feeding_group_product');
    }
    public function feedingRecords(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FeedingRecord::class);
    }
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id');
    }
    public function cattle_type()
    {
        return $this->belongsTo(CattleType::class, 'cattle_type_id');
    }
    public function feeding_category()
    {
        return $this->belongsTo(FeedingCategory::class, 'feeding_category_id');
    }
    public function feeding_moment()
    {
        return $this->belongsTo(FeedingMoment::class, 'feeding_moment_id');
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
