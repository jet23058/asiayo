<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Exceptions\StatusMessages\CurrencyStatus;
use Illuminate\Support\Facades\Storage;

/**
 * Class CurrencyService
 * @package App
 */
class CurrencyService
{
    /**
     * @param string $file
     * @return array
     * @throws ApiException
     * @throws \JsonException
     */
    public function currencies(string $file): array
    {
        $sourceData = Storage::get($file);

        if (empty($sourceData)) {
            throw new ApiException(CurrencyStatus::SOURCE_NOTFOUND);
        }

        $source = json_decode($sourceData, true, 512, JSON_THROW_ON_ERROR);

        return $source['currencies'];
    }

    /**
     * @param float $rate
     * @param float $amount
     * @return string
     * @throws ApiException
     */
    public function exchange(float $rate, float $amount): string
    {
        try {
            $sum = bcmul($rate, $amount, 4);
        } catch (\Throwable $exception) {
            \Log::alert("計算錯誤，rate: {$rate}, amount:{$amount}");
            throw new ApiException(CurrencyStatus::CALCULATION_ERROR);
        }

        return number_format($sum, 2);
    }
}