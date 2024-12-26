<?php

namespace SolidGate\API\DTO\Request\PaymentPage\InitRequest;

class PageCustomizationDTO implements \JsonSerializable
{
    /**
     * Shop name.
     *
     * Also, it is possible to fill in the HUB Public Information section and after it is visible to customers on the payment page.
     * @var string
     */
    private $publicName;
    private $orderTitle;
    private $orderDescription;
    private $paymentMethods;
    private $buttonFontColor;
    private $buttonColor;
    private $fontName;
    private $isCardHolderVisible;
    private $termsUrl;
    private $backUrl;

    public function __construct(string $publicName)
    {
        $this->publicName = $publicName;
    }

    public function jsonSerialize(): array
    {
        return [
            'public_name' => $this->publicName,
        ];
    }
}