<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name_plural',
    ];

    public function rate(): HasOne
    {
        return $this->hasOne(CurrencyRate::class);
    }

    public function scopeByCode($query, string $code)
    {
        return $query->where('code', $code);
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper(trim($value))
        );
    }
}
