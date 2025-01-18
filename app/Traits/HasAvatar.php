<?php

namespace App\Traits;

trait HasAvatar
{
    /**
     * Get the user's avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        // Si un avatar personnalisé est défini
        if ($this->avatar) {
            return $this->avatar;
        }

        // Utiliser Gravatar comme solution de repli
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=200&d=mp";
    }

    /**
     * Get initials from name.
     *
     * @return string
     */
    public function getInitialsAttribute(): string
    {
        $name = trim($this->name);
        if (empty($name)) {
            return '?';
        }

        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
        }

        return mb_strtoupper(mb_substr($name, 0, 2));
    }
}
