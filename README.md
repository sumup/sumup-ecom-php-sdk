# SumUp Ecommerce PHP SDK

## Overview

This repository contains the open source PHP SDK that allows you to integrate quickly with the SumUp's [API](https://developer.sumup.com/rest-api) endpoints.

## Installation

The SumUp eCom PHP SDK can be installed with [Composer](https://getcomposer.org/). Run the following command:

```
composer require sumup/sumup-ecom-php-sdk
```

## Basic usage

```php
try {
    $sumup = new \SumUp\SumUp([
        'app_id'     => 'YOUR-CLIENT-ID',
        'app_secret' => 'YOUR-CLIENT-SECRET',
        'code'       => 'YOUR-AUTHORIZATION-CODE'
    ]);
    $checkoutService = $sumup->getCheckoutService();
    $checkoutResponse = $checkoutService->create($amount, $currency, $checkoutRef, $payToEmail);
    $checkoutId = $checkoutResponse->getBody()->id;
//  pass the $chekoutId to the front-end to be processed
} catch (\SumUp\Exceptions\SumUpAuthenticationException $e) {
    echo 'Authentication error: ' . $e->getMessage();
} catch (\SumUp\Exceptions\SumUpResponseException $e) {
    echo 'Response error: ' . $e->getMessage();
} catch(\SumUp\Exceptions\SumUpSDKException $e) {
    echo 'SumUp SDK error: ' . $e->getMessage();
}
```

## API Reference

For a full list of classes, see the [API reference page](https://github.com/sumup/sumup-ecom-php-sdk/tree/master/docs).

## FAQ

* [How to authorize?](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/HowToAuthorize.md)
* [How to handle exceptions?](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/ExceptionsHandling.md)
* [How to use my own HTTP client?](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/HowToOverrideHttpClient.md)

## Roadmap

| Version | Status | PHP Version |
|--- |--- |--- |
| 1.x | Latest | \>= 5.6 |

## License

For information about the license see the [license](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/LICENSE.md) file.

## Contact us

If you have found a bug or you lack some functionality please [open an issue](https://github.com/sumup/sumup-ecom-php-sdk/issues/new). If you have other issues when integrating with SumUp's API you can send an email to [integration@sumup.com](mailto:integration@sumup.com).
