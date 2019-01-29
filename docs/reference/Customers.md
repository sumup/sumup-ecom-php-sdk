# Customers service for the SumUp Ecommerce SDK for PHP

## \SumUp\Services\Customers

The `\SumUp\Services\Customers` is responsible for managing customers and assigning payment instruments to them (if you have that functionality enabled).

```php
$customerService = new \SumUp\Services\Customers(
    \SumUp\HttpClients\SumUpHttpClientInterface $client,
    \SumUp\Authentication\AccessToken $accessToken
);
```

## Instance Methods

### create()

Creates a new customer.

```php
public function create(
    string $customerId,
    array  $customerDetails = [],
    array  $customerAddress = []
): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### update()

Updates information about a customer.

```php
public function update(
    string $customerId,
    array  $customerDetails = [],
    array  $customerAddress = []
): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### get()

Returns information about a particular customer.

```php
public function get(string $customerId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### getPaymentInstruments()

Returns payment instruments assigned to that particular customer.

```php
public function getPaymentInstruments(string $customerId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### deletePaymentInstruments()

Deactivates a payment instrument for a customer.

```php
public function deletePaymentInstruments(
    string $customerId,
    string $cardToken
): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.
