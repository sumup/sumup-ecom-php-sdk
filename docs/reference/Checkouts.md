# Checkouts service for the SumUp Ecommerce SDK for PHP

## \SumUp\Services\Checkouts

The `\SumUp\Services\Checkouts` service is responsible for managing the checkouts - creating, listing, processing, deactivating.

```php
$checkoutService = new \SumUp\Services\Checkouts(
    \SumUp\HttpClients\SumUpHttpClientInterface $client,
    \SumUp\Authentication\AccessToken $accessToken
);
```

## Instance Methods

### create()

Creates a new checkout.

```php
public function create(
    float  $amount,
    string $currency,
    string $checkoutRef,
    string $payToEmail,
    string $description = '',
    string $payFromEmail = null,
    string $returnURL = null
): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### findById()

Searches for a checkout with particular `id`.

```php
public function findById(string $checkoutId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### findByReferenceId()

Searches for a checkout with particular `checkout_reference_id`.

```php
public function findByReferenceId(string $referenceId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### delete()

Deactivates a checkout with particular `checkout_reference_id`;

```php
public function delete(string $checkoutId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### pay()

Processes a checkout with tokenized card for a customer.

> **Note:** this is not the only way to process a checkout. For more information [read this guide](https://developer.sumup.com/docs/single-payment).

```php
public function pay(
    string $checkoutId,
    string $customerId,
    string $cardToken,
    int    $installments = 1
): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.
