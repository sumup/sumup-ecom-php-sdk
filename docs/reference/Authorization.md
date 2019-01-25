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
public SumUp\Authentication\AccessToken getToken()
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

### getTokenByCode()

```php
public SumUp\Authentication\AccessToken getTokenByCode()
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

## getTokenByClientCredentials()

```php
public SumUp\Authentication\AccessToken getTokenByClientCredentials()
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

## getTokenByPassword()

```php
public SumUp\Authentication\AccessToken getTokenByPassword()
```

Returns a `SumUp\Authentication\AccessToken` according to the initial configuration or throws an exception.

## refreshToken()

```php
public SumUp\Authentication\AccessToken refreshToken($refreshToken)

```

Returns a `SumUp\Authentication\AccessToken` using the provided the refresh token or throws an exception.
