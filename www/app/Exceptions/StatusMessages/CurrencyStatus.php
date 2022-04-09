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
    public const CALCULATION_ERROR = [
        'http_status_code' => Response::HTTP_BAD_REQUEST,
        'message' => '計算發生錯誤',
    ];
}