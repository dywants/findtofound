<?php

namespace App\Models;

use App\Enum\PieceCondition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Thefind extends Model
{
    use HasFactory;
    use HasSlug;

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
        'photos',
        'is_anonymous',
        'localisation',
        // Nouveaux champs
        'contact_person',
        'pickup_hours',
        'special_instructions',
        'discovery_date',
        'piece_condition',
        'condition_details',
        'deposit_location',
        'deposit_city',
        'deposit_district'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
        'discovery_date' => 'datetime',
        'photos' => 'array',
        'piece_condition' => PieceCondition::class
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

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}