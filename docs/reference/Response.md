# Response for the SumUp Ecommerce SDK for PHP

## \SumUp\HttpClients\Response

The `\SumUp\HttpClients\Response` object is the main object that is returned from every successful service call.

## Instance Methods

### getHttpResponseCode()

```php
public function getHttpResponseCode(): int
```

Returns the HTTP response code.

### getBody()

```php
public function getBody(): mixed
```

Returns different object according to the service's response.
