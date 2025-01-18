<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtectedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filename',
        'original_name',
        'purpose',
        'watermark_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
