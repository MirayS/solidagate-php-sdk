<?php

declare(strict_types=1);

namespace SolidGate\API\Enum;

class SubscriptionCancelCodeEnum
{
    public const CARD_BRAND_IS_NOT_SUPPORTED = '8.01';
    public const FRAUD_CHARGEBACK_RECEIVED = '8.02';
    public const DISPUTE_RECEIVED = '8.03';
    public const FRAUD_ALERT_RECEIVED = '8.04';
    public const FRAUD_DECLINE_RECEIVED = '8.05';
    public const CANCELLATION_BY_SUPPORT = '8.06';
    public const RECURRING_PAYMENT_ID_BLOCKED_BY_ANTIFRAUD = '8.07';
    public const SUBSCRIPTION_HAS_EXPIRED = '8.08';
    public const CANCELLATION_AFTER_REDEMPTION_PERIOD = '8.09';
    public const CARD_TOKEN_HAS_EXPIRED = '8.10';
    public const TOKEN_REVOKED_BY_CUSTOMER = '8.11';
    public const BANK_ANTIFRAUD_SYSTEM = '8.12';
    public const INVALID_AMOUNT = '8.13';
    public const CANCELLATION_BY_CUSTOMER = '8.14';
    public const RECURRING_TOKEN_IS_NOT_FOUND = '8.15';

    public const DEFAULT_CANCEL_CODES = [
        self::CARD_BRAND_IS_NOT_SUPPORTED,
        self::FRAUD_CHARGEBACK_RECEIVED,
        self::DISPUTE_RECEIVED,
        self::FRAUD_ALERT_RECEIVED,
        self::FRAUD_DECLINE_RECEIVED,
        self::CANCELLATION_BY_SUPPORT,
        self::RECURRING_PAYMENT_ID_BLOCKED_BY_ANTIFRAUD,
        self::SUBSCRIPTION_HAS_EXPIRED,
        self::CANCELLATION_AFTER_REDEMPTION_PERIOD,
        self::CARD_TOKEN_HAS_EXPIRED,
        self::TOKEN_REVOKED_BY_CUSTOMER,
        self::BANK_ANTIFRAUD_SYSTEM,
        self::INVALID_AMOUNT,
        self::CANCELLATION_BY_CUSTOMER,
        self::RECURRING_TOKEN_IS_NOT_FOUND,
    ];

    public static function isDefaultCancellationCode(string $code): bool
    {
        return in_array($code, self::DEFAULT_CANCEL_CODES);
    }
}