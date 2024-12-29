[![PHP version](https://badge.fury.io/ph/mirays%2Fsolidgate-php-sdk.svg)](https://badge.fury.io/ph/mirays%2Fsolidgate-php-sdk.svg)

# SolidGate API


This library provides API options of SolidGate payment gateway.

## Installation

### With Composer

```
$ composer require mirays/solidgate-php-sdk
```

```json
{
    "require": {
        "mirays/solidgate-php-sdk": "~0.1"
    }
}
```

## Usage

Payment Form Init Example

Card-gate example

```php
<?php

use SolidGate\API\PaymentPageApi;
use SolidGate\API\DTO\Request\PaymentPage\InitRequest;


$api = new PaymentPageApi('YourMerchantId', 'YourPrivateKey');

$request = new InitRequest(
    new InitRequest\SubscriptionOrderDTO('ProductId','OrderId', 'CustomerId', 'OrderDescription'),
    new InitRequest\PageCustomizationDTO('PublicName')
);

$response = $api->initPage($request);
```