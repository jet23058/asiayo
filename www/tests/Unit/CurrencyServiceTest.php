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

    public function testExchangeSuccess(): void
    {
        // arrange
        $rate = 3.1415926;
        $amount = 1234;
        $expected = '3,876.73';

        // action
        $exchange = app(CurrencyService::class)->exchange($rate, $amount);

        // assert
        $this->assertSame($exchange, $expected);
    }

    public function getExchangeData(): array
    {
        return [
            '匯率低於限制' => [
                'rate' => 0.000098,
                'amount' => 100,
                'expected' => ApiException::class,
            ],
            '金額低於限制' => [
                'rate' => 3.1415926,
                'amount' => 0.0000000001,
                'expected' => ApiException::class,
            ],
        ];
    }

    /**
     * @dataProvider getExchangeData
     * @param float $rate
     * @param float $amount
     * @param string $expected
     * @throws ApiException
     */
    public function testExchangeFailed(float $rate, float $amount, string $expected): void
    {
        // arrange

        // assert
        $this->expectException($expected);
        $this->expectExceptionCode(400);

        // action
        app(CurrencyService::class)->exchange($rate, $amount);
    }
}
