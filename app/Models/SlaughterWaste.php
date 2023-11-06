<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlaughterWaste extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'slaughter_wastes';
    protected $fillable = [
        'unique_id',
        'date',
        'slaughter_store_id',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];
    public function slaughter_store()
    {
        return $this->belongsTo(SlaughterStore::class, 'slaughter_store_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_slaughter_waste')->withPivot('unit_price','quantity','sub_total');

    }
}
