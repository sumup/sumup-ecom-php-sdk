# Merchant service for the SumUp Ecommerce SDK for PHP

## \SumUp\Services\Merchant

The `\SumUp\Services\Merchant` service is responsible for managing data about merchants.

```php
$merchantService = new \SumUp\Services\Merchant(
    \SumUp\HttpClients\SumUpHttpClientInterface $client,
    \SumUp\Authentication\AccessToken $accessToken
);
```

## Instance Methods

### getProfile()

Returns information about the merchant's profile.

```php
public function getProfile(): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### updateProfile()

Updates merchant's profile.

```php
public function updateProfile(array $data): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### getDoingBusinessAs()

Returns doing-business-as profile.

```php
public function getDoingBusinessAs(): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### updateDoingBusinessAs()

Updates doing-business-as profile.

```php
public function updateDoingBusinessAs(array $data): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.
