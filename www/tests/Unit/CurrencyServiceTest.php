<?php

namespace Tests\Unit;

use App\Exceptions\ApiException;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class CurrencyServiceTest
 * @package Tests\Unit
 */
class CurrencyServiceTest extends TestCase
{
    /**
     * @throws ApiException
     * @throws \JsonException
     */
    public function testRates(): void
    {
        // arrange
        $rate = ['TWD' => ['TWD' => 1]];
        Storage::shouldReceive('get')->andReturn(json_encode(['currencies' => $rate], JSON_THROW_ON_ERROR));

        // action
        $currencies = app(CurrencyService::class)->currencies('test.path');

        // assert
        $this->assertSame($currencies, $rate);
    }

    public function testExchange(): void
    {
        // arrange
        $rate = 3.1415926;
        $amount = 1234;

        // action
        $exchange = app(CurrencyService::class)->exchange($rate, $amount);

        // assert
        $this->assertSame($exchange, '3,876.73');
    }
}
