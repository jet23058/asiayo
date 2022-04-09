<?php

namespace App\Exceptions\StatusMessages;

use Illuminate\Http\Response;

/**
 * Class CurrencyStatus
 * @package App\Exceptions\StatusMessages
 */
final class CurrencyStatus
{
    public const SOURCE_NOTFOUND = [
        'http_status_code' => Response::HTTP_NOT_FOUND,
        'message' => '匯率資料不存在',
    ];
}