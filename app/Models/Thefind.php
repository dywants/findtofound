<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thefind extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'fullName',
        'findCity',
        'user_id',
        'ward',
        'details',
        'amount_check',
        'piece_id',
        'approval_status',
        'photos'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class);
    }
}
