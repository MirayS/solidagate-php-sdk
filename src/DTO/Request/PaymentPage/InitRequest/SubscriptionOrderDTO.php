<?php

declare(strict_types=1);

namespace SolidGate\API\DTO\Request\PaymentPage\InitRequest;

class SubscriptionOrderDTO extends BaseOrderDTO
{
    /**
     * Product identifier of the subscription.
     *
     * One of product_id or product_price_id is required for subscription.
     * @var string|null
     */
    private $productId;

    /**
     * Price identifier of the predefined product.
     *
     * It is preferred to set product_price_id to manage subscription data.
     *
     * To get product_price_id, use get product prices.
     *
     * One of product_id or product_price_id is required for subscription.
     * @var string|null
     */
    private $productPriceId;

    /**
     * Customer identifier defined by the merchant.
     * @var string
     */
    private $customerAccountId;

    public function __construct(?string $productId, string $customerAccountId, string $orderId, string $orderDescription, ?string $productPriceId = null)
    {
        if (empty($productId) && empty($productPriceId)) {
            throw new \InvalidArgumentException('Product id or product price id is required');
        }

        $this->productId = $productId;
        $this->productPriceId = $productPriceId;
        $this->customerAccountId = $customerAccountId;
        parent::__construct($orderId, $orderDescription);
    }

    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();

        if (!empty($this->productId)) {
            $json['product_id'] = $this->productId;
        }

        if (!empty($this->productPriceId)) {
            $json['product_price_id'] = $this->productPriceId;
        }

        if (!empty($this->customerAccountId)) {
            $json['customer_account_id'] = $this->customerAccountId;
        }

        return $json;
    }
}