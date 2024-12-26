<?php

declare(strict_types=1);

namespace SolidGate\API\DTO\Request\PaymentPage\InitRequest;

abstract class BaseOrderDTO implements \JsonSerializable
{
    /**
     * Required
     *
     * Order identifier defined by the merchant, which can be used later to find this payment. (255 symbols limit)
     * @var string
     */
    private $orderId;

    /**
     * Required
     *
     * A description of the order.
     *
     * To improve the clarity of payment processing, it is advised to keep the description brief, ideally not exceeding 100 characters.
     * @var string
     */
    private $orderDescription;

    /**
     * List and description of the items included in the order.
     * @var string
     */
    private $orderItems;

    /**
     * Date of order creation defined by the merchant.
     * @var \DateTimeImmutable
     */
    private $orderDate;

    /**
     * Index number of order per customer.
     * @var int
     */
    private $orderNumber;

    /**
     * Specifies the payment processing flow.
     *
     * For a two-step payment flow to ensure better control over the transaction process and include the settle_interval parameter in hours.
     * @var string
     */
    private $type = 'auth';

    /**
     * Delay applied before transaction settlement indicates the hours to wait before settling and should be provided together with authorization.
     *
     * 240 hours = 10 days for Visa customer-initiated payments
     *
     * 120 hours = 5 days for Visa merchant-initiated payments
     *
     * 144 hours = 6 days for all other card brands
     * @var int
     */
    private $settleInterval;

    /**
     * Number of retry attempts for the subscription payments.
     *
     * This parameter is used for analytics and conversion tuning purposes.
     * @var int
     */
    private $retryAttempt;

    /**
     * Indicates whether to force 3D Secure (3DS) authentication.
     * @var bool
     */
    private $force3ds = false;

    /**
     * Array of allowed Google Pay authorization methods.
     *
     * PAN_ONLY - this authentication method is associated with payment cards stored on file with the user’s Google Account. Returned payment data includes personal account number (PAN) with the expiration month and the expiration year.
     * CRYPTOGRAM_3DS - this authentication method is associated with cards stored as Android device tokens. Returned payment data includes a 3-D Secure (3DS) cryptogram generated on the device.
     * The capability to transmit only PAN_ONLY or CRYPTOGRAM_3DS is also available, and such transmission will work for both one-time payments and subscriptions.
     *
     * @var array
     */
    private $googlePayAllowedAuthMethods;

    /**
     * Customer's date of birth.
     * @var \DateTimeImmutable
     */
    private $customerDateOfBirth;

    /**
     * Customer's email address.
     *
     * Can be used for sending receipts and notifications; if not provided, the field still appears on the payment page with a note "For receipts and notifications".
     * @var string
     */
    private $customerEmail;

    /**
     * Customer's first name.
     * @var string
     */
    private $customerFirstName;

    /**
     * Customer's last name.
     * @var string
     */
    private $customerLastName;

    /**
     * Customer's phone number.
     * @var string
     */
    private $customerPhone;

    /**
     * Indicates the origin of the traffic that led to the transaction.
     * @var string
     */
    private $trafficSource;

    /**
     * Provide additional context about the source of the transaction for better segmentation and analysis.
     * @var string
     */
    private $transactionSource;

    /**
     * Country where the goods are purchased or where the seller is based is identified using the ISO-3166 alpha-3 country code.
     *
     * If registered as a marketplace with international payment systems, this parameter is required. Being a marketplace means you operate a platform where multiple sellers offer goods or services.
     * @var string ISO-3166 alpha-3 country code
     */
    private $purchaseCountry;

    /**
     * Customer's registration country.
     * @var string
     */
    private $geoCountry;

    /**
     * Customer's registration city.
     * @var string
     */
    private $geoCity;

    /**
     * Payment page language.
     * @var string Enum ("da" "de" "el" "en" "es" "fi" "fr" "it" "nl" "no" "pl" "pt" "ro" "sv" "uk")
     */
    private $language;

    /**
     * Website from which the transaction took place.
     * @var string
     */
    private $website;

    /**
     * Metadata is useful for storing additional, structured information about an object.
     * @var object <= 10 properties
     */
    private $orderMetadata;

    /**
     * URL for browser redirect after a successful payment.
     * @var string
     */
    private $successUrl;

    /**
     * URL for browser redirect after a failed payment.
     * @var string
     */
    private $failUrl;

    public function __construct(string $orderId, string $orderDescription) {
        $this->orderId = $orderId;
        $this->orderDescription = $orderDescription;
    }

    public function jsonSerialize(): array
    {
        $json = [
            'order_id' => $this->orderId,
            'order_description' => $this->orderDescription,
        ];

        if (!empty($this->orderItems)) {
            $json['order_items'] = $this->orderItems;
        }

        if (!empty($this->orderDate)) {
            $json['order_date'] = $this->orderDate->format('Y-m-d H:i:s');
        }

        if (!empty($this->orderNumber)) {
            $json['order_number'] = $this->orderNumber;
        }

        if (!empty($this->type)) {
            $json['type'] = $this->type;
        }

        if (!empty($this->settleInterval)) {
            $json['settle_interval'] = $this->settleInterval;
        }

        if (!empty($this->retryAttempt)) {
            $json['retry_attempt'] = $this->retryAttempt;
        }

        if (!empty($this->force3ds)) {
            $json['force3ds'] = $this->force3ds;
        }

        if (!empty($this->googlePayAllowedAuthMethods)) {
            $json['google_pay_allowed_auth_methods'] = $this->googlePayAllowedAuthMethods;
        }

        if (!empty($this->customerDateOfBirth)) {
            $json['customer_date_of_birth'] = $this->customerDateOfBirth->format('Y-m-d');
        }

        if (!empty($this->customerEmail)) {
            $json['customer_email'] = $this->customerEmail;
        }

        if (!empty($this->customerFirstName)) {
            $json['customer_first_name'] = $this->customerFirstName;
        }

        if (!empty($this->customerLastName)) {
            $json['customer_last_name'] = $this->customerLastName;
        }

        if (!empty($this->customerPhone)) {
            $json['customer_phone'] = $this->customerPhone;
        }

        if (!empty($this->trafficSource)) {
            $json['traffic_source'] = $this->trafficSource;
        }

        if (!empty($this->transactionSource)) {
            $json['transaction_source'] = $this->transactionSource;
        }

        if (!empty($this->purchaseCountry)) {
            $json['purchase_country'] = $this->purchaseCountry;
        }

        if (!empty($this->geoCountry)) {
            $json['geo_country'] = $this->geoCountry;
        }

        if (!empty($this->geoCity)) {
            $json['geo_city'] = $this->geoCity;
        }

        if (!empty($this->language)) {
            $json['language'] = $this->language;
        }

        if (!empty($this->website)) {
            $json['website'] = $this->website;
        }

        if (!empty($this->orderMetadata)) {
            $json['order_metadata'] = $this->orderMetadata;
        }

        if (!empty($this->successUrl)) {
            $json['success_url'] = $this->successUrl;
        }

        if (!empty($this->failUrl)) {
            $json['fail_url'] = $this->failUrl;
        }

        return $json;
    }

    public function setOrderItems(string $orderItems): BaseOrderDTO
    {
        $this->orderItems = $orderItems;
        return $this;
    }

    public function setOrderDate(\DateTimeImmutable $orderDate): BaseOrderDTO
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    public function setOrderNumber(int $orderNumber): BaseOrderDTO
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function setSettleInterval(int $settleInterval): BaseOrderDTO
    {
        $this->settleInterval = $settleInterval;
        return $this;
    }

    public function setRetryAttempt(int $retryAttempt): BaseOrderDTO
    {
        $this->retryAttempt = $retryAttempt;
        return $this;
    }

    public function setForce3ds(bool $force3ds): BaseOrderDTO
    {
        $this->force3ds = $force3ds;
        return $this;
    }

    public function setGooglePayAllowedAuthMethods(array $googlePayAllowedAuthMethods): BaseOrderDTO
    {
        $this->googlePayAllowedAuthMethods = $googlePayAllowedAuthMethods;
        return $this;
    }

    public function setCustomerDateOfBirth(\DateTimeImmutable $customerDateOfBirth): BaseOrderDTO
    {
        $this->customerDateOfBirth = $customerDateOfBirth;
        return $this;
    }

    public function setCustomerEmail(string $customerEmail): BaseOrderDTO
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    public function setCustomerFirstName(string $customerFirstName): BaseOrderDTO
    {
        $this->customerFirstName = $customerFirstName;
        return $this;
    }

    public function setCustomerLastName(string $customerLastName): BaseOrderDTO
    {
        $this->customerLastName = $customerLastName;
        return $this;
    }

    public function setCustomerPhone(string $customerPhone): BaseOrderDTO
    {
        $this->customerPhone = $customerPhone;
        return $this;
    }

    public function setTrafficSource(string $trafficSource): BaseOrderDTO
    {
        $this->trafficSource = $trafficSource;
        return $this;
    }

    public function setTransactionSource(string $transactionSource): BaseOrderDTO
    {
        $this->transactionSource = $transactionSource;
        return $this;
    }

    public function setPurchaseCountry(string $purchaseCountry): BaseOrderDTO
    {
        $this->purchaseCountry = $purchaseCountry;
        return $this;
    }

    public function setGeoCountry(string $geoCountry): BaseOrderDTO
    {
        $this->geoCountry = $geoCountry;
        return $this;
    }

    public function setGeoCity(string $geoCity): BaseOrderDTO
    {
        $this->geoCity = $geoCity;
        return $this;
    }

    public function setLanguage(string $language): BaseOrderDTO
    {
        $this->language = $language;
        return $this;
    }

    public function setWebsite(string $website): BaseOrderDTO
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @param object $orderMetadata
     * @return BaseOrderDTO
     */
    public function setOrderMetadata($orderMetadata)
    {
        $this->orderMetadata = $orderMetadata;
        return $this;
    }

    public function setSuccessUrl(string $successUrl): BaseOrderDTO
    {
        $this->successUrl = $successUrl;
        return $this;
    }

    public function setFailUrl(string $failUrl): BaseOrderDTO
    {
        $this->failUrl = $failUrl;
        return $this;
    }
}