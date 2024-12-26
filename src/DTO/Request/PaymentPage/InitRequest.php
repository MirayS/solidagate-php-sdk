<?php

declare(strict_types=1);

namespace SolidGate\API\DTO\Request\PaymentPage;

use Psr\Http\Message\RequestInterface;
use SolidGate\API\DTO\Request\PaymentPage\InitRequest\BaseOrderDTO;
use SolidGate\API\DTO\Request\PaymentPage\InitRequest\PageCustomizationDTO;

class InitRequest implements \JsonSerializable
{
    private $order;
    private $pageCustomization;

    public function __construct(BaseOrderDTO $order, PageCustomizationDTO $pageCustomization)
    {
        $this->order = $order;
        $this->pageCustomization = $pageCustomization;
    }

    public function jsonSerialize(): array
    {
        return [
            'order' => $this->order,
            'page_customization' => $this->pageCustomization,
        ];
    }

    public function getOrder(): BaseOrderDTO
    {
        return $this->order;
    }

    public function getPageCustomization(): PageCustomizationDTO
    {
        return $this->pageCustomization;
    }
}