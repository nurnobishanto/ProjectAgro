<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlaughterStock extends Model
{
    use HasFactory;
    protected $table = 'slaughter_stocks';
    protected $fillable = [
        'slaughter_store_id',
        'product_id',
        'quantity',
    ];

    public function slaughter_store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SlaughterStore::class);
    }
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
