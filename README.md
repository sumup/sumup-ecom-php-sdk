<div align="center">

# SumUp Ecommerce PHP SDK

[![Stars](https://img.shields.io/github/stars/sumup/sumup-ecom-php-sdk?style=social)](https://github.com/sumup/sumup-go/)
[![Latest Stable Version](https://poser.pugx.org/sumup/sumup-ecom-php-sdk/v/stable.svg)](https://packagist.org/packages/sumup/sumup-ecom-php-sdk)
[![Total Downloads](https://poser.pugx.org/sumup/sumup-ecom-php-sdk/downloads.svg)](https://packagist.org/packages/sumup/sumup-ecom-php-sdk)
[![License](https://img.shields.io/github/license/sumup/sumup-go)](./LICENSE)
[![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-v2.1%20adopted-ff69b4.svg)](https://github.com/sumup/sumup-go/tree/main/CODE_OF_CONDUCT.md)

</div>

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
    $merchantCode = 'YOUR-MERCHANT-CODE';
    $checkoutResponse = $checkoutService->create($amount, $currency, $checkoutRef, $merchantCode);
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

### TLS certificates

The SDK now ships with the latest Mozilla CA bundle to prevent `SSL certificate problem: unable to get local issuer certificate` errors on Windows and other environments that do not expose a system-wide trust store. You can override the bundled file by passing the `ca_bundle_path` configuration key:

```php
$sumup = new \SumUp\SumUp([
    'app_id'         => 'YOUR-CLIENT-ID',
    'app_secret'     => 'YOUR-CLIENT-SECRET',
    'code'           => 'YOUR-AUTHORIZATION-CODE',
    'ca_bundle_path' => __DIR__ . '/storage/certs/company-ca.pem',
]);
```

If not provided, the bundled `resources/ca-bundle.crt` file is used automatically by both the cURL and Guzzle HTTP clients.

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
