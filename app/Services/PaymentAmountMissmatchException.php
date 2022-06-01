<?php

namespace App\Services;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class PaymentAmountMissmatchException extends Exception
{
    public function __construct(int $value, int $expected)
    {
        parent::__construct(sprintf('%s attendu est different de %s', $expected,$value));
    }
}
