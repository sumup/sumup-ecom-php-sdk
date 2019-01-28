# SumUp Ecommerce PHP SDK

## Overview

This repository contains the open source PHP SDK that allows you to integrate quickly with the SumUp's ecommerce [API](https://developer.sumup.com/rest-api) endpoints. As a transport layer it support cURL or [GuzzleHttp](https://packagist.org/packages/guzzlehttp/guzzle) but they are not required if you provide your own.

## Installation

The SumUp eCom PHP SDK can be installed with [Composer](https://getcomposer.org/). Run the following command:

```
composer require sumup/sumup-ecom-php-sdk
```

> **Note:** This version of the SumUp SDK for PHP requires PHP 5.6 or greater.

## Basic usage

```php
try {
    $sumup = new \SumUp\SumUp([
        'app_id' => 'YOUR-CLIENT-ID',
        'app_secret' => 'YOUR-CLIENT-SECRET',
        'code' => 'YOUR-AUTHORIZATION-CODE'
    ]);
    $checkoutService = $sumup->getCheckoutService();
    $checkoutResponse = $checkoutService->create(/* pass here the required arguments */);
//  use the variable $checkoutResponse
} catch(\SumUp\Exceptions\SumUpSDKException $e) {
    echo 'SumUp SDK error: ' . $e->getMessage();
}
```

## Services

To get a particular service you first need to create a `\SumUp\SumUp` object. Then from this object you can get any of the services we support in the SDK.

Here is an example how to get transactions history:

```php
try {
    $sumup = new \SumUp\SumUp([
        'app_id' => 'YOUR-CLIENT-ID',
        'app_secret' => 'YOUR-CLIENT-SECRET',
        'grant_type' => 'authorization_code',
        'scope' => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
        'code' => 'YOUR-AUTHORIZATION-CODE'
    ]);
    $transactionsService = $sumup->getTransactionService();
    $filters = [
        'limit' => 100,
        'statuses' => ['SUCCESSFUL', 'REFUND']
    ];
    $transactionsHistory = $transactionsService->getTransactionHistory($filters)->getBody();
//  you can now iterate over the result in $transactionsHistory
} catch (\SumUp\Exceptions\SumUpSDKException $e) {
//  handle exceptions
}
```

> All services' methods return response of type `\SumUp\HttpClients\Response` or throw an exception (view [exceptions handling](https://github.com/sumup/sumup-ecom-php-sdk#exceptions-handling)).

## Exceptions handling

Exceptions handling is an important part of our code. We pay attention to this detail and **we recommend to wrap every statement from this SDK with a `try {} catch() {}` clause**.

You should at least handle `\SumUp\Exceptions\SumUpSDKException` exception but if you want you can handle all sorts of exceptions.

```php
try {
    $sumup = new \SumUp\SumUp(/* configuration */);
} catch (\SumUp\Exceptions\SumUpAuthenticationException $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
} catch (\SumUp\Exceptions\SumUpResponseException $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
} catch (\SumUp\Exceptions\SumUpSDKException $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
}
```

Here is a table with all the exceptions that are thrown from this SDK:
 
| Exception | Conditions   	|
|---	    |---	        |
|`\SumUp\Exceptions\SumUpAuthenticationException`| This exception is thrown when there is no access token or it is already expired. |
|`\SumUp\Exceptions\SumUpConnectionException`    | This exception is thrown when there is connectivity issues over the network. 	|
|`\SumUp\Exceptions\SumUpResponseException`   	 | This exception is thrown when there are some [4xx http errors](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes#4xx_Client_errors) such as `404 Not Found`.   	|
|`\SumUp\Exceptions\SumUpValidationException`    | This exception is thrown when there is one or more wrong data send to the server. In the message there is information about which field(s) is incorrect.  	|
|`\SumUp\Exceptions\SumUpServerException`   	 | This exception is thrown when there are http errors of [5xx](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes#5xx_Server_errors). 	|
|`\SumUp\Exceptions\SumUpConfigurationException` | This exception is thrown when you provide a bad configuration for initialization of the `\SumUp\SumUp` object.	|
|`\SumUp\Exceptions\SumUpArgumentException`  	 | This exception is thrown when you don't provide a mandatory argument to a function. 	|
|`\SumUp\Exceptions\SumUpSDKException`           | This is the main exception which others inherit from. So this is the last exception to handle in your code if you want to catch many exceptions.|

## Roadmap

| Version | Status | PHP Version |
|--- |--- |--- |
| 1.x | Latest | \>= 5.6 |

## License

For information about the license see the [license](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/LICENSE) file.

## Contact us

If you have found a bug or you lack some functionality please [open an issue](https://github.com/sumup/sumup-ecom-php-sdk/issues/new). If you have other issues when integrating with SumUp's API you can send an email to [integration@sumup.com](mailto:integration@sumup.com).
