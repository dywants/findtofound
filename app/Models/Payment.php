<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['type_piece', 'user_payer_id', 'order_id','thefind_id', 'amount','currency','paymentSource','payment_status'];
}
