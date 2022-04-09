<?php

namespace Tests\Feature\Http\Controllers;

use App\Services\CurrencyService;
use Tests\TestCase;

/**
 * Class CurrencyControllerTest
 * @package Tests\Feature\Http\Controllers
 */
class CurrencyControllerTest extends TestCase
{
    public function getCurrencyExchangeRateSuccessData(): array
    {
        return [
            'TWD to JPY' => [
                'source' => 'TWD',
                'target' => 'JPY',
                'amount' => 1,
                'expected' => '3.67',
            ],
            'JPY to USD' => [
                'source' => 'JPY',
                'target' => 'USD',
                'amount' => 1,
                'expected' => '0.01',
            ],
            'USD to TWD' => [
                'source' => 'USD',
                'target' => 'TWD',
                'amount' => 1,
                'expected' => '30.44',
            ],
            'USD to TWD-decimal' => [
                'source' => 'USD',
                'target' => 'TWD',
                'amount' => 0.0022,
                'expected' => '0.07',
            ],
            'USD to TWD-large amount' => [
                'source' => 'USD',
                'target' => 'TWD',
                'amount' => 12345678,
                'expected' => '375,851,821.03',
            ],
        ];
    }

    /**
     * @dataProvider getCurrencyExchangeRateSuccessData
     * @param string $source
     * @param string $target
     * @param float $amount
     * @param string $expected
     */
    public function testCurrencyExchangeRateSuccess(string $source, string $target, float $amount, string $expected): void
    {
        // arrange
        $request = [
            'source' => $source,
            'target' => $target,
            'amount' => $amount,
        ];

        // action
        $response = $this->post(route('currency.exchange-rate'), $request);

        // assert
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'amount' => $expected,
            ],
        ]);
    }

    public function getCurrencyExchangeRateFailedData(): array
    {
        return [
            'source error' => [
                'source' => 'HKD',
                'target' => 'TWD',
                'amount' => 1,
                'error_field' => 'source',
            ],
            'target error' => [
                'source' => 'TWD',
                'target' => 'HKD',
                'amount' => 1,
                'error_field' => 'target',
            ],
            'amount error' => [
                'source' => 'TWD',
                'target' => 'HKD',
                'amount' => 'test',
                'error_field' => 'amount',
            ],
        ];
    }

    /**
     * @dataProvider getCurrencyExchangeRateFailedData
     * @param string $source
     * @param string $target
     * @param $amount
     * @param string $errorField
     */
    public function testCurrencyExchangeRateFailed(string $source, string $target, $amount, string $errorField): void
    {
        // arrange
        $request = [
            'source' => $source,
            'target' => $target,
            'amount' => $amount,
        ];

        // action & assert
        $this->post(route('currency.exchange-rate'), $request)->assertSessionHasErrors($errorField);
    }

    public function testCurrencyDataSourceNotExists(): void
    {
        // arrange
        $request = [
            'source' => 'TWD',
            'target' => 'JPY',
            'amount' => 1,
        ];

        $this->mock(CurrencyService::class)->makePartial(['currencies'])->shouldReceive('currencies')->andReturn([]);

        // action
        $response = $this->post(route('currency.exchange-rate'), $request);

        // assert
        $response->assertStatus(404);
        $response->assertJson([
            'status' => '00010001',
        ]);
    }
}
