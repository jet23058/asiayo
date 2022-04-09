<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use App\Exceptions\ApiException;
use App\Exceptions\StatusMessages\CurrencyStatus;
use App\Http\Requests\CurrencyExchangeRateRequest;
use Illuminate\Http\Response;

/**
 * Class CurrencyController
 * @package App\Http\Controllers
 * @group Currency
 */
class CurrencyController extends Controller
{
    /** @var CurrencyService */
    private $service;

    /**
     * CurrencyController constructor.
     * @param CurrencyService $service
     */
    public function __construct(CurrencyService $service)
    {
        $this->service = $service;
    }

    /**
     * 匯率轉換 (currency.exchange-rate)
     * @response 200 {"data":{"amount":"3.67"},"message":null}
     * @response 400 {"data":null,"message":{"source":["The selected source is invalid."]}}
     * @param CurrencyExchangeRateRequest $request
     * @return Response
     * @throws ApiException
     * @throws \JsonException
     */
    public function exchangeRate(CurrencyExchangeRateRequest $request): Response
    {
        $data = $request->validated();

        $currencies = $this->service->currencies('public/currency.json');

        if (empty($currencies[$data['source']][$data['target']])) {
            throw new ApiException(CurrencyStatus::SOURCE_NOTFOUND);
        }

        $amount = $this->service->exchange($currencies[$data['source']][$data['target']], $data['amount']);

        return response([
            'data' => ['amount' => $amount],
            'message' => null,
        ]);
    }
}
