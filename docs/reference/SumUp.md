# SumUp service for the SumUp Ecommerce SDK for PHP

## \SumUp\SumUp

The `\SumUp\SumUp` service is the main entry point for the SDK. From it you can get an instance to every other service (this is the recommended way of using it).

Every time when an instance of `\SumUp\SumUp` is created a call to SumUp's servers is made to acquire an access token. If don't need this you can pass configuration with an existing access token or a refresh token.

```php
try {
    $sumup = new \SumUp\SumUp([
        'app_id' => 'YOUR-CLIENT-ID',
        'app_secret' => 'YOUR-CLIENT-SECRET',
        'code' => 'YOUR-AUTHORIZATION-CODE'
    ]);
} catch(\SumUp\Exceptions\SumUpSDKException $e) {
    echo 'SumUp SDK error: ' . $e->getMessage();
}
try {
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

## Instance Methods

### getAccessToken()

```php
public function getAccessToken(): \SumUp\Authentication\AccessToken
```

Returns a `\SumUp\Authentication\AccessToken` object.

### refreshToken()

```php
public function refreshToken(string $refreshToken = null): \SumUp\Authentication\AccessToken
```

Returns a `\SumUp\Authentication\AccessToken` or throws an exception.

### getAuthorizationService()

```php
public function getAuthorizationService(\SumUp\Application\ApplicationConfigurationInterface $config = null): \SumUp\Services\Authorization
```

Returns an instance of `\SumUp\Services\Authorization`.

### getCheckoutService()

```php
public function getCheckoutService(\SumUp\Application\ApplicationConfigurationInterface $config = null): \SumUp\Services\Checkouts
```

Returns an instance of `\SumUp\Services\Checkouts`.

### getCustomerService()

```php
public function getCustomerService(\SumUp\Application\ApplicationConfigurationInterface $config = null): \SumUp\Services\Customers
```

Returns an instance of `\SumUp\Services\Customers`.

### getTransactionService()

```php
public function getTransactionService(\SumUp\Application\ApplicationConfigurationInterface $config = null): \SumUp\Services\Transactions
```

Returns an instance of `\SumUp\Services\Transactions`.

### getMerchantService()

```php
public function getMerchantService(\SumUp\Application\ApplicationConfigurationInterface $config = null): \SumUp\Services\Merchant
```

Returns an instance of `\SumUp\Services\Merchant`.

### getPayoutService()

```php
public function getPayoutService(\SumUp\Application\ApplicationConfigurationInterface $config = null): \SumUp\Services\Payouts
```

Returns an instance of `\SumUp\Services\Payouts`.

### getCustomService()

```php
public function getCustomService(\SumUp\Application\ApplicationConfigurationInterface $config = null): \SumUp\Services\Custom
```

Returns an instance of `\SumUp\Services\Custom`.
