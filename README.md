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

## Configurations

```php
$sumup = new \SumUp\SumUp([
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
|access_token | This is the value of a valid access token that is acquired through other methods. It is used if you don't want to request new access token | `string` | `null` | No	|
|refresh_token | This is the refresh token through which can be requested new access token | `string` | `null` | No	|
|use_guzzlehttp_over_curl | This is a configuration whether to use GuzzleHttp if both GuzzleHttp library and cURL module are installed. | `bool` | `false` | No	|
|custom_headers | This sends custom headers with every http request to SumUp server | `array` with key-value pairs containing the header's name (as key) and the header's value (as value) | `[]` | No	|

## Authorization

Every time you make an instance of the `\SumUp\SumUp` class you get a valid OAuth 2.0 access token. The access token is then passed automatically to every service call you make but of course you can override this (see examples below). In case you need the access token you can access it like this:

```php
$sumup = new \SumUp\SumUp([
    'app_id' => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
//  other configurations
]);
$accessToken = $sumup->getAccessToken();
//  use the accessToken object as you need to
echo $accessToken->getValue() . ' ' . $accessToken->getRefreshToken();
```

This SDK supports 3 authorization flows which are described in [this guide](https://developer.sumup.com/docs/authorization).

### Authorization code flow

```php
$sumup = new \SumUp\SumUp([
    'app_id' => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'authorization_code',
    'scope' => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'code' => 'YOUR-AUTHORIZATION-CODE'
]);
```

For more information about this flow read more in [this guide](https://developer.sumup.com/docs/authorization#authorization-code-flow).

### Client credentials flow

```php
$sumup = new \SumUp\SumUp([
    'app_id' => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'client_credentials',
    'scope' => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly']
]);
```

For more information about this flow read more in [this guide](https://developer.sumup.com/docs/authorization#client-credentials-flow).

### Password flow

```php
$sumup = new \SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'password',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'username'   => 'YOUR-SUMUP-USERNAME',
    'password'   => 'YOUR-SUMUP-PASSWORD'
]);
```

### Reuse access token

In case you **already have a valid access token** you can **reuse it** like this:

```php
$sumup = new \SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'access_token' => 'VALID-ACCESS-TOKEN'
]);
```

### Use refresh token

Here is how to get a **new access token from a refresh token**:

```php
$sumup = new \SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'refresh_token' => 'REFRESH-TOKEN'
]);
$sumup->refreshToken();
```

### Override access token

You can always **initialize** some **service** with a new **access token** like this:

```php
$checkoutService = $sumup->getCheckoutService('VALID-ACCESS-TOKEN');
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
