<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyRate extends Model
{
    protected $fillable = [
        'currency_id',
        'latest_exchange_rate',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeByCurrencyId($query, int $currencyId)
    {
        return $query->where('currency_id', $currencyId);
    }
}
