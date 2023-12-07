<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cattle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'session_year_id',
      'farm_id',
      'tag_id',
      'entry_date',
      'shade_no',
      'is_purchase',
      'purchase_date',
      'purchase_price',
      'dob',
      'batch_id',
      'cattle_type_id',
      'breed_id',
      'image',
      'gender',
      'category',
      'parent_id',
      'dairy_date',
      'last_dairy_date',
      'total_child',
      'pregnant_date',
      'pregnant_no',
      'delivery_date',
      'created_by',
      'updated_by',
      'status',
      'problem',
      'death_reason',
      'death_date',
      'sold_date',
      'supplier_id',
    ];
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cattle::class, 'parent_id');
    }
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function cattle_structures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CattleStructure::class);
    }
    public function cattle_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CattleType::class);
    }
    public function breeds(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Breeds::class,'breed_id');
    }
    public function batch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Batch::class,'batch_id');
    }
    public function session_year(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SessionYear::class);
    }
    public function farm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
    public function feedingRecords(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(FeedingRecord::class, 'feeding_record_cattle');
    }
    public function dewormers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Dewormer::class);
    }

    public function vaccines(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Vaccine::class);
    }

}
