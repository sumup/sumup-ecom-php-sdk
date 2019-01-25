# ApplicationConfiguration for the SumUp Ecommerce SDK for PHP

## \SumUp\Application\ApplicationConfiguration

The `\SumUp\Application\ApplicationConfiguration` entity provides all the configurations needed to work with this SDK.

## Instance Methods

### getAppId()

```php
public function getAppId(): string
```

Returns the app id.

### getAppSecret()

```php
public function getAppSecret(): string
```

Returns the app secret.

### getScopes()

```php
public function getScopes(): array
```

Returns an array with scopes.

### getFormattedScopes()

```php
public function getFormattedScopes(): string
```

Returns scopes formatted for requests.

### getCode()

```php
public function getCode(): ?string
```

Returns code needed for authorization with grant type `authorization_code`.

### getGrantType()

```php
public function getGrantType(): string
```

Returns a string with value one of: `authorization_code`, `client_credentials`, `password`.

### getUsername()

```php
public function getUsername(): ?string
```

Returns username needed for authorization with grant type `password`.

### getPassword()

```php
public function getPassword(): ?string
```

Returns password needed for authorization with grant type `password`.

### getAccessToken()

```php
public function getAccessToken(): ?string
```

Returns the value of an access token.

### getRefreshToken()

```php
public function getRefreshToken(): ?string
```

Returns the value of a refresh token.

### getForceGuzzle()

```php
public function getForceGuzzle(): bool
```

Returns a flag whether [GuzzleHttp](https://packagist.org/packages/guzzlehttp/guzzle) should be used instead of cURL.
