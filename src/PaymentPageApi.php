<?php

declare(strict_types=1);

namespace SolidGate\API;

use SolidGate\API\BaseApi;
use SolidGate\API\DTO\Request\PaymentPage\InitRequest;

class PaymentPageApi extends BaseApi
{
    protected const BASE_SOLID_GATE_API_URI = 'https://payment-page.solidgate.com/api/v1/';

    private const INIT_PATH = 'init';

    public function initPage(InitRequest $request): string
    {
        return $this->sendRequest(self::INIT_PATH, $request);
    }
}