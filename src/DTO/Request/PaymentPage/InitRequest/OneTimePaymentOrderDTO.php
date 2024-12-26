<?php

declare(strict_types=1);

namespace SolidGate\API\DTO\Request\PaymentPage\InitRequest;

class OneTimePaymentOrderDTO extends BaseOrderDTO
{
    /**
     * Order amount in its smallest currency unit (cents for euros).
     *
     * For instance, 1020 means 10 EUR and 20 cents.
     *
     * However, the value 0 is valid only for zero-amount authorization flow. In cases where the amount received from APM systems is 0, only PayPal is queried for processing.
     * @var integer
     */
    private $amount;

    /**
     * Three-letter ISO-4217 currency code of the product price currency.
     * @var string
     */
    private $currency;

    public function __construct(int $amount, string $currency, string $orderId, string $orderDescription) {
        $this->amount = $amount;
        $this->currency = $currency;
        parent::__construct($orderId, $orderDescription);
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();

        $json['amount'] = $this->amount;
        $json['currency'] = $this->currency;

        return $json;
    }
}