<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Piece extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'slug', 'amount'];

    /**
     * @return BelongsTo
     */
    public function thefind(): BelongsTo
    {
        return $this->belongsTo(Thefind::class);
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

//    /**
//     * Get the route key for the model.
//     *
//     * @return string
//     */
//    public function getRouteKeyName(): string
//    {
//        return 'slug';
//    }
}
