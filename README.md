
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
composer require sergeynezbritskiy/privatbank-api:"^1.0.0"
```

## Notes
For the full list of supported requests see phpdoc for \SergeyNezbritskiy\PrivatBank\Client class.

For the full list of required/supported params to some request, see description to this request.

All requests classes can be found within \SergeyNezbritskiy\PrivatBank\Request namespace.

## Simple usage
Using library is as easy as possible
```php
//create client for connecting with API
$client = new \SergeyNezbritskiy\PrivatBank\Client();
//create request instance
$request = $client->infrastructure();
//run the request
$response = $request->execute([
    'type' => \SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest::TYPE_ATM,
    'city' => 'Днепропетровск',
])->toArray();
```
