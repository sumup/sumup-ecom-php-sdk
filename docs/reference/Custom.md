# Custom service for the SumUp Ecommerce SDK for PHP

## \SumUp\Services\Custom

The `\SumUp\Services\Custom` service should be used for the endpoints that are not implemented by the SDK.

```php
$customService = new \SumUp\Services\Custom(
  \SumUp\HttpClients\SumUpHttpClientInterface $client,
  \SumUp\Application\ApplicationConfiguration $configuration
);
```

## Instance Methods

### request()

```php
public function request(
  string $method,
  string $relativePath,
  array  $payload = null
): \SumUp\HttpClients\Response
```

`$method` is one of: `GET`, `POST`, `PUT`, `DELETE`.

`$relativePath` is relative path to the resource. For example: `/v0.1/me`.

`$payload` is optional but if you provide it it should be an associative array with the needed data.
