<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

/**
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends \Exception
{
    /** @var string */
    private $responseCode;

    /** @var array */
    private $data;

    /**
     * ApiMessageException constructor.
     * @param array $statusMessages
     * @param array $data
     */
    public function __construct(array $statusMessages, array $data = [])
    {
        parent::__construct();

        $this->code = $statusMessages['http_status_code'];
        $this->message = $statusMessages['message'];
        $this->data = $data;
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'data' => $this->data,
            'message' => $this->message,
        ], $this->code);
    }
}
