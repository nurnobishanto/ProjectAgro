<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedingRecord extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['date','feeding_group_id','status','comment','per_cattle_cost','total_cost','created_by','updated_by'];

    public function feedingGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FeedingGroup::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'feeding_record_product')->withPivot('unit_price','quantity','total_cost');

    }

    public function cattles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Cattle::class, 'feeding_record_cattle');
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
