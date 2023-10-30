<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BulkCattleSale extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'bulk_cattle_sales';

    protected $fillable = [
        'unique_id',
        'date',
        'account_id',
        'party_id',
        'cattle_type_id',
        'farm_id',
        'amount',
        'paid',
        'due',
        'expense',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function farm()
    {
        return $this->belongsTo(Farm::class, 'farm_id');
    }
    public function cattle_type()
    {
        return $this->belongsTo(CattleType::class, 'cattle_type_id');
    }
    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    // Define the many-to-many relationship with Cattle
    public function cattles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Cattle::class, 'cattle_bulk_cattle_sale', 'bulk_cattle_sale_id', 'cattle_id');
    }
}
