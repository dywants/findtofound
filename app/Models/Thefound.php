<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thefound extends Model
{
    use HasFactory;

    protected $fillable = ['thefind_id', 'user_id', 'amount'];

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
    public function thefind(): BelongsTo
    {
        return $this->belongsTo(Thefind::class);
    }
}
