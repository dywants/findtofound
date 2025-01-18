<?php

namespace App\Helpers;

class MoneyHelper
{
    /**
     * Format a number as money
     *
     * @param float|int|string $amount
     * @param string $currency
     * @return string
     */
    public static function format($amount, $currency = 'EUR')
    {
        $amount = floatval($amount);
        return number_format($amount, 2, ',', ' ') . ' ' . $currency;
    }

    /**
     * Calculate order amount
     *
     * @param float|int|string $amount
     * @return float
     */
    public static function orderAmount($amount)
    {
        return floatval($amount);
    }

    /**
     * Calculate piece amount
     *
     * @param int $pieceId
     * @return float
     */
    public static function pieceAmount($pieceId)
    {
        // Implement your piece amount calculation logic here
        // For now, returning a default value
        return 0.00;
    }
}
