<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reward extends Model
{
    use HasFactory;

    /**
     * @return HasOne
     */
    public function reward(): HasOne
    {
        return $this->hasOne(Piece::class);
    }
}
