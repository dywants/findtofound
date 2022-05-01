<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Piece extends Model
{
    use HasFactory;

    /**
     * @return Money
     */
    public function formattedPrice(): Money
    {
        return money($this->amount);
    }

    /**
     * @param $value
     * @return Money
     */
    public function setAmountAttribute($value): Money
    {
        return money($value);
    }

    /**
     * @return BelongsTo
     */
    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
