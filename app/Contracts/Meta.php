<?php

namespace App\Contracts;

class Meta
{
    protected static array $meta = [];

    public static function addMeta($name, $content): void
    {
        static::$meta[$name] = $content;
    }

    public static function render(): string
    {
        $html = '';
        foreach (static::$meta as $name => $content) {
            $html .= '<meta name="'.$name.'" content="'.$content.'" />'.PHP_EOL;
        }
        return $html;
    }

    public static function cleanup(): void
    {
        static::$meta = [];
    }
}
