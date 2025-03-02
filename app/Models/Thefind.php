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
        'want_reward',
        // Champs pour tous les scénarios
        'discovery_date',
        'piece_condition',
        'condition_details',
        // Champs spécifiques au dépôt
        'deposit_date',
        'deposit_location',
        'deposit_city',
        'deposit_district',
        'contact_person',
        'pickup_hours',
        'special_instructions'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
        'want_reward' => 'boolean',
        'discovery_date' => 'datetime',
        'deposit_date' => 'date',
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
            ->generateSlugsFrom('fullName')
            ->saveSlugsTo('slug');
    }
    
    /**
     * Détermine si cette déclaration est pour un objet sans demande de récompense
     *
     * @return bool
     */
    public function isNoRewardPath(): bool
    {
        return !$this->want_reward;
    }

    /**
     * Détermine si cette déclaration est pour un objet avec demande de récompense anonyme
     *
     * @return bool
     */
    public function isAnonymousRewardPath(): bool
    {
        return $this->want_reward && $this->is_anonymous;
    }

    /**
     * Détermine si cette déclaration est pour un objet avec demande de récompense non-anonyme
     *
     * @return bool
     */
    public function isIdentifiedRewardPath(): bool
    {
        return $this->want_reward && !$this->is_anonymous;
    }
    
    /**
     * Scope pour filtrer les déclarations sans récompense
     */
    public function scopeNoReward($query)
    {
        return $query->where('want_reward', false);
    }

    /**
     * Scope pour filtrer les déclarations avec récompense
     */
    public function scopeWithReward($query)
    {
        return $query->where('want_reward', true);
    }

    /**
     * Scope pour filtrer les déclarations anonymes
     */
    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true);
    }

    /**
     * Scope pour filtrer les déclarations avec compte utilisateur
     */
    public function scopeWithUser($query)
    {
        return $query->where('is_anonymous', false)
                     ->whereNotNull('user_id');
    }
}