<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['type_piece', 'user_payer_id', 'order_id','thefind_id', 'amount','currency','paymentSource','payment_status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userPayer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_payer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thefind(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Thefind::class);
    }
}
