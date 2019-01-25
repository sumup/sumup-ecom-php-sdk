# Authorization service for the SumUp Ecommerce SDK for PHP

## SumUp\Services\Authorization

The `SumUp\Services\Authorization` service is responsible for getting a valid access token.

```php
$authService = new \SumUp\Services\Authorization($client, $configuration);
/* 
 * $client - instance of a class that implements the interface SumUp\HttpClients\SumUpHttpClientInterface
 * $configuration - instance of a class that implements the interface SumUp\Application\ApplicationConfiguration
 */
```

## Instance Methods

### getToken()

```php
public function getToken(): SumUp\Authentication\AccessToken
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

### getTokenByCode()

```php
public function getTokenByCode(): SumUp\Authentication\AccessToken
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

### getTokenByClientCredentials()

```php
public function getTokenByClientCredentials(): SumUp\Authentication\AccessToken
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

### getTokenByPassword()

```php
public function getTokenByPassword(): SumUp\Authentication\AccessToken
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

### refreshToken()

```php
public function refreshToken($refreshToken): SumUp\Authentication\AccessToken

```

Returns a `SumUp\Authentication\AccessToken` using the provided the refresh token or throws an exception.
