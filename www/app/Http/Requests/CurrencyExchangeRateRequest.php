<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CurrencyExchangeRateRequest
 * @bodyParam source required string 來源幣別
 * @bodyParam target required string 目標幣別
 * @bodyParam amount required numeric 金額數字
 * @package App\Http\Requests
 */
class CurrencyExchangeRateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'source' => ['required', 'string', Rule::in(Currency::ALLOW_MAP)],
            'target' => ['required', 'string', Rule::in(Currency::ALLOW_MAP)],
            'amount' => ['required', 'numeric'],
        ];
    }
}