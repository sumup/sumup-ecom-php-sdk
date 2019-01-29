# Payouts service for the SumUp Ecommerce SDK for PHP

## \SumUp\Services\Payouts

The `\SumUp\Services\Payouts` service is responsible for getting information about payouts.

```php
$payoutService = new \SumUp\Services\Payouts(
    \SumUp\HttpClients\SumUpHttpClientInterface $client,
    \SumUp\Authentication\AccessToken $accessToken
);
```

## Instance Methods

### getPayouts()

Returns information about payouts.

```php
public function getPayouts(
    string $startDate,
    string $endDate,
    int    $limit = 10,
    bool   $descendingOrder = true,
    string $format = 'json'
): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### getTransactions()

Returns information about payed out transactions.

```php
public function getTransactions(
    string $startDate,
    string $endDate,
    int    $limit = 10,
    boo    $descendingOrder = true,
    string $format = 'json'
): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.
