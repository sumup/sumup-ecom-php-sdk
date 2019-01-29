# How to authorize using the SDK

## Overview

This guide will help you to authorize and get an OAuth 2.0 token using the SDK. If you want to know what happens behind the scenes you can visit this [authorization guide](https://developer.sumup.com/docs/authorization).

Every time you make an instance of the `\SumUp\SumUp` class you get a valid OAuth 2.0 access token. The access token is then passed to every service call you make (but of course you can [override](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/HowToOverrideHttpClient.md) this).

## Authorization code flow

> **Note:** this is the flow we recommend.

First you need to send the merchant to pass through the [authorization flow](https://developer.sumup.com/docs/authorization#1-your-application-requests-authorization) so you can get a `code` and after that you can continue with the following example code.

```php
$sumup = new \SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'authorization_code',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'code'       => 'YOUR-AUTHORIZATION-CODE'
]);
$accessToken = $sumup->getAccessToken();
$refreshToken = $accessToken->getRefreshToken();
$value = $accessToken->getValue();
```

> **Note:** once you get a refresh token you can store it in a database and then use it to get new access tokens for the same merchant.

For more information about this flow read in [this guide](https://developer.sumup.com/docs/authorization#authorization-code-flow).

## Client credentials flow

If you want to use just the `client_id` and the `client_secret` you can use following snippet of code but keep in mind that not all endpoints can be requested with access token from this flow.

```php
$sumup = new \SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'client_credentials',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly']
]);
$accessToken = $sumup->getAccessToken();
$value = $accessToken->getValue();
```

For more information about this flow read in [this guide](https://developer.sumup.com/docs/authorization#client-credentials-flow).

## Password flow

Here is an example how you can use the `password` flow. But also keep in mind that not all endpoints can be requested with access token from this flow.

```php
$sumup = new \SumUp\SumUp([
    'app_id'     => 'YOUR-CLIENT-ID',
    'app_secret' => 'YOUR-CLIENT-SECRET',
    'grant_type' => 'password',
    'scope'      => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'username'   => 'YOUR-SUMUP-USERNAME',
    'password'   => 'YOUR-SUMUP-PASSWORD'
]);
$accessToken = $sumup->getAccessToken();
$value = $accessToken->getValue();
```

## How to get new access from a refresh token

Here is how to get a **new access token from a refresh token**:

```php
$sumup = new \SumUp\SumUp([
    'app_id'        => 'YOUR-CLIENT-ID',
    'app_secret'    => 'YOUR-CLIENT-SECRET',
    'scope'         => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'refresh_token' => 'REFRESH-TOKEN'
]);
// you need to call the method `refreshToken()` to get a new access token
$refreshedAccessToken = $sumup->refreshToken();
$value = $refreshedAccessToken->getValue();
```

> **Note:** keep in mind that the refresh token can also expire although it has long life span. For more information you can read [here](https://developer.sumup.com/docs/authorization#6-the-authorization-server-returns-an-access-token).

## How to reuse a valid access token

If you already have a valid access token you can reuse it like this:

```php
$sumup = new \SumUp\SumUp([
    'app_id'       => 'YOUR-CLIENT-ID',
    'app_secret'   => 'YOUR-CLIENT-SECRET',
    'scope'        => ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'],
    'access_token' => 'VALID-ACCESS-TOKEN'
]);
```

## Override access token for a service

You can always initialize a service with an access token that is different from the one you already have from your `SumUp\SumUp` instance.

```php
$checkoutService = $sumup->getCheckoutService('ACCESS-TOKEN-INSTANCE');
```
