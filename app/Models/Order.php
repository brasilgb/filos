<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    
    public $incrementing = false;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
