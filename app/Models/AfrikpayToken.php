<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfrikpayToken extends Model
{
    use HasFactory;

    protected $fillable = ["token_key", "code"];

}
