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
    $sumup = new SumUp\SumUp([
        'app_id' => 'YOUR-CLIENT-ID',
        'app_secret' => 'YOUR-CLIENT-SECRET',
        'code' => 'YOUR-AUTHORIZATION-CODE'
    ]);
    $checkoutService = $sumup->getCheckoutService();
    $checkoutResponse = $checkoutService->create(/* pass here the required arguments */);
    /* use the variable $checkoutResponse */
} catch(\SumUp\Exceptions\SumUpSDKException $e) {
    echo 'SumUp SDK error: ' . $e->getMessage();
}
```

## Configurations

```php
$sumup = new SumUp\SumUp([
//  'config-name': 'config-value'
]);
```

| Name	| Description | Value	| Default value | Required	 |
|---	|---	|---	|---	|---	|
|app_id | This is the client id that you receive after you [register](https://developer.sumup.com/docs/register-app) your application in SumUp | `string`| *No default value* | Yes |
|app_secret | This is the client secret that corresponds to the client id | `string` | *No default value* | Yes |
|grant_type | This indicates which authorization flow should be used to acquire OAuth token | One of: `authorization_code`, `client_credentials`, `password` | '`authorization_code`' | No |
|scopes | This is an array with all the [authorization scopes](https://developer.sumup.com/docs/authorization#authorization-scopes) that you need for your application | `array` with possible values: `payments`, `transactions.history`, `user.app-settings`, `user.profile_readonly`, `user.profile`, `user.subaccounts`, `user.payout-settings`, `balance`, `products` | `['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly']` | No |
|code | This is the code returned at the last step from [authorization code flow](https://developer.sumup.com/docs/authorization#authorization-flows) | `string` | `null` | Conditional (required only if `grant_type => 'authorization_code'`) |
|username | This is your SumUp's username if you want to use password authorization flow | `string` | `null` | Conditional (required only if `grant_type => 'password'`) |
|password | This is your SumUp's password if you want to use password authorization flow | `string` | `null` | Conditional (required only if `grant_type => 'password'`) |
|default_access_token | This is the value of a valid access token that is acquired through other methods. It is used if you don't want to request new access token | `string` | `null` | No	|
|default_refresh_token | This is the refresh token through which can be requested new access token | `string` | `null` | No	|
|use_guzzlehttp_over_curl | This is a configuration whether to use GuzzleHttp if both GuzzleHttp library and cURL module are installed. | `bool` | `false` | No	|
|custom_headers | This sends custom headers with every http request to SumUp server | `array` with key-value pairs containing the header's name (as key) and the header's value (as value) | `[]` | No	|
|base_uri | This is the base location of SumUp's servers. This is not recommended to be used | `string` | '`https\://api.sumup.com`'	| No |

### Authorization

Every time you make an instance of the `\SumUp\SumUp` class you get a valid OAuth 2.0 access token. The access token is then passed automatically to every service call you make but of course you can override this (see examples below). In case you need the access token you can access it like this:

```php
$sumup = \SumUp\SumUp([
    'app_id' => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    // other configurations
]);
$accessToken = $sumup->getAccessToken();
// use the accessToken object as you need to
echo $accessToken->getValue() . ' ' . $accessToken->getRefreshToken();
```

This SDK supports 3 authorization flows which are described in [this guide](https://developer.sumup.com/docs/authorization).

* Authorization code flow

```php
$sumup = new SumUp\SumUp([
    'app_id' => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'authorization_code',
    'scope' => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'code' => 'YOUR-AUTHORIZATION-CODE'
]);
```

For more information about this flow read more in [this guide](https://developer.sumup.com/docs/authorization#authorization-code-flow).

* Client credentials flow

```php
$sumup = new SumUp\SumUp([
    'app_id' => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'client_credentials',
    'scope' => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly']
]);
```

For more information about this flow read more in [this guide](https://developer.sumup.com/docs/authorization#client-credentials-flow).

* Password flow

```php
$sumup = new SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'password',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'username'   => 'YOUR-SUMUP-USERNAME',
    'password'   => 'YOUR-SUMUP-PASSWORD'
]);
```

In case you already have a valid access token you can reuse it like this:

```php
$sumup = new SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'default_access_token' => 'VALID-ACCESS-TOKEN'
]);
```

Here is how to get a new access token from a refresh token:

```php
$sumup = new SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'default_access_token' => 'VALID-ACCESS-TOKEN',
    'default_refresh_token' => 'REFRESH-TOKEN'
]);
$sumup->refreshToken();
```

You can always initialize some service with a new access token like this:

```php
$checkoutService = $sumup->getCheckoutService('VALID-ACCESS-TOKEN');
```

### Services

### Exceptions handling

## Development

## License

For information about the license see the [license](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/LICENSE) file.



