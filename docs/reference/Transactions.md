# Transactions service for the SumUp Ecommerce SDK for PHP

## \SumUp\Services\Transactions

The `\SumUp\Services\Transactions` service is responsible for managing transactions: getting transactions, getting transactions history, making refunds, getting receipts.

```php
$transactionService = new \SumUp\Services\Transactions(
    \SumUp\HttpClients\SumUpHttpClientInterface $client,
    \SumUp\Authentication\AccessToken $accessToken
);
```

## Instance Methods

### findById()

Searches for a transaction by `id`.

```php
public function findById(string $transactionId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### findByInternalId()

Searches for a transaction by `internal_id`.

```php
public function findByInternalId(string $internalId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### findByTransactionCode()

Searches for a transaction by `transaction_code`.

```php
public function findByTransactionCode(string $transactionCode): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### getTransactionHistory()

Returns a list of all transactions according to the provided filter.

```php
public function getTransactionHistory(array $filters = []): \SumUp\HttpClients\Response
```

Available `filters` are:

| Key | Type | Default value | 
|---	|---	|---	|
| `order`         | String             | `ascending`. |
| `limit`         | Integer            | 10 |
| `user_id`       | String             | `null` |
| `users `        | Array              | `[]` |
| `statuses`      | Array              | `[]` |
| `payment_types` | Array              | `[]` |
| `types`         | Array              | `[]` |
| `changes_since` | String\<date-time> | `null` |
| `newest_time`   | String\<date-time> | `null` |
| `newest_ref`    | String             | `null` |
| `oldest_time`   | String\<date-time> | `null` |
| `oldest_ref`    | String             | `null` |

> **Note:** for more information about the filters read the [API documentation](https://developer.sumup.com/rest-api/#tag/Transactions).

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### refund()

Refunds a transaction partially or fully depending on the `amount`.

```php
public function refund(string $transactionId, float $amount = null): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.

### getReceipt()

Returns receipt data about a transaction.

```php
public function getReceipt(string $transactionId, string $merchantId): \SumUp\HttpClients\Response
```

Returns a `\SumUp\HttpClients\Response` or throws an exception.
