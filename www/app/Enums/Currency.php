<?php

namespace App\Enums;

/**
 * Class Currency
 * @package App\Enums
 */
class Currency
{
    /** @var string */
    public const USD = 'USD';

    /** @var string */
    public const TWD = 'TWD';

    /** @var string */
    public const JPY = 'JPY';

    /** @var string[]  */
    public const ALLOW_MAP = [
        self::USD,
        self::TWD,
        self::JPY,
    ];
}