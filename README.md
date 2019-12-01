# PrivatBank API

Library for connecting your PHP application with PrivatBank API

[![Build Status](https://travis-ci.org/sergeynezbritskiy/privatbank-api.svg?branch=master)](https://travis-ci.org/sergeynezbritskiy/privatbank-api)
[![Latest Stable Version](https://poser.pugx.org/sergeynezbritskiy/privatbank-api/v/stable)](https://packagist.org/packages/sergeynezbritskiy/privatbank-api)
[![Total Downloads](https://poser.pugx.org/sergeynezbritskiy/privatbank-api/downloads)](https://packagist.org/packages/sergeynezbritskiy/privatbank-api)
[![Latest Unstable Version](https://poser.pugx.org/sergeynezbritskiy/privatbank-api/v/unstable)](https://packagist.org/packages/sergeynezbritskiy/privatbank-api)
[![License](https://poser.pugx.org/sergeynezbritskiy/privatbank-api/license)](https://packagist.org/packages/sergeynezbritskiy/privatbank-api)

## Installation
The easiest way to install module is using Composer
```
composer require sergeynezbritskiy/privatbank-api:"^3.0"
```

## Notes
For more details please visit [https://api.privatbank.ua/]

## Simple usage
Using library is as easy as possible
```php
//create public client for connecting with API
$client = new \SergeyNezbritskiy\PrivatBank\PublicClient();
//run the request
$result = $client->infrastructure(\SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest::TYPE_ATM, 'Днепр');

//create authorized client for connecting with API
$client = new \SergeyNezbritskiy\PrivatBank\AuthorizedClient();
//create merchant
$merchant = new \SergeyNezbritskiy\PrivatBank\Merchant('<your_merchant_id>', '<your_merchant_secret>');
$client->setMerchant($merchant);
//run the request
$result = $client->balance('4111111111111111');
```
