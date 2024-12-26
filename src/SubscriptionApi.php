<?php

declare(strict_types=1);

namespace SolidGate\API;

use SolidGate\API\Enum\SubscriptionCancelCodeEnum;

class SubscriptionApi extends BaseApi
{
    protected const BASE_SOLID_GATE_API_URI = 'https://subscriptions.solidgate.com/api/v1/';
    private const PRODUCTS_PATH = 'products';

    private const SUBSCRIPTION_SWITCH_PRODUCT_PATH = 'subscription/switch-subscription-product';
    private const SUBSCRIPTION_UPDATE_TOKEN = 'subscription/update-token';
    private const CANCEL_SUBSCRIPTION = 'subscription/cancel';
    private const CANCEL_SUBSCRIPTION_BY_CUSTOMER = 'subscription/cancel-by-customer';
    private const RESTORE_SUBSCRIPTION = 'subscription/restore';

    public function getProductList(): string
    {
        $request = $this->makeRequest(self::PRODUCTS_PATH, null, 'GET');

        $response = $this->solidGateApiClient->send($request);

        return $response->getBody()->getContents();
    }

    public function subscriptionSwitchProduct(string $subscripionId, string $productId): bool
    {
        $request = $this->makeRequest(self::SUBSCRIPTION_SWITCH_PRODUCT_PATH, [
            'subscription_id' => $subscripionId,
            'new_product_id' => $productId,
        ]);

        $response = $this->solidGateApiClient->send($request);

        return true;
    }

    public function updateSubscriptionToken(string $subscriptionId, string $token): bool
    {
        $request = $this->makeRequest(self::SUBSCRIPTION_UPDATE_TOKEN, [
            'subscription_id' => $subscriptionId,
            'token' => $token,
        ]);

        $response = $this->solidGateApiClient->send($request);

        return true;
    }

    public function cancelSubscription(string $subscriptionId, bool $force = false, string $cancelCode = SubscriptionCancelCodeEnum::CANCELLATION_BY_CUSTOMER): string
    {
        return $this->sendRequest(self::CANCEL_SUBSCRIPTION, [
            'subscription_id' => $subscriptionId,
            'force' => $force,
            'cancel_code' => $cancelCode,
        ]);
    }

    public function cancelSubscriptionByCustomer(string $customerAccountId, bool $force = false, string $cancelCode = SubscriptionCancelCodeEnum::CANCELLATION_BY_CUSTOMER): string
    {
        return $this->sendRequest(self::CANCEL_SUBSCRIPTION_BY_CUSTOMER, [
            'customer_account_id' => $customerAccountId,
            'force' => $force,
            'cancel_code' => $cancelCode,
        ]);
    }

    public function restoreSubscription(string $subscriptionId, ?\DateTimeImmutable $expiredAt = null): string
    {
        $attributes = [
            'subscription_id' => $subscriptionId,
        ];

        if (null !== $expiredAt) {
            $attributes['expired_at'] = $expiredAt->format('Y-m-d H:i:s');
        }

        return $this->sendRequest(self::RESTORE_SUBSCRIPTION, $attributes);
    }
}