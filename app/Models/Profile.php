<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'city', 'phone_number', 'photo_url', 'cover_photo_url'
    ];
    
    protected $appends = ['full_photo_url', 'full_cover_photo_url'];
    
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the full URL for the profile photo
     *
     * @return string|null
     */
    public function getFullPhotoUrlAttribute()
    {
        if (!$this->photo_url) {
            return null;
        }
        
        // Si l'URL commence déjà par http:// ou https://, retourner tel quel
        if (strpos($this->photo_url, 'http://') === 0 || strpos($this->photo_url, 'https://') === 0) {
            return $this->photo_url;
        }
        
        // Sinon, ajouter l'URL de base
        return url($this->photo_url);
    }
    
    /**
     * Get the full URL for the cover photo
     *
     * @return string|null
     */
    public function getFullCoverPhotoUrlAttribute()
    {
        if (!$this->cover_photo_url) {
            return null;
        }
        
        // Si l'URL commence déjà par http:// ou https://, retourner tel quel
        if (strpos($this->cover_photo_url, 'http://') === 0 || strpos($this->cover_photo_url, 'https://') === 0) {
            return $this->cover_photo_url;
        }
        
        // Sinon, ajouter l'URL de base
        return url($this->cover_photo_url);
    }
}
