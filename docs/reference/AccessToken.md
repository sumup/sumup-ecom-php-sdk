# AccessToken for the SumUp Ecommerce SDK for PHP

Requests to the SumUp's API need to have an access token sent with them to identify the application and the user. The `\SumUp\Authentication\AccessToken` entity represents an access token.

## \SumUp\Authentication\AccessToken

Every time you create an instance of `\SumUp\SumUp` you get an `AccessToken` that can be used to request other resources.

## Instance Methods

### getValue()

```php
public function getValue(): string
```

Returns the actual value of the access token as a string.

### getType()

```php
public function getType(): string
```

Returns the type of authentication that the access token should be used for.

### getExpiresIn()

```php
public function getExpiresIn(): int
```

Returns the total number of seconds the access token is valid for.

### getScopes()

```php
public function getScopes(): array
```

Returns the scopes for which the access token is valid.

### getRefreshToken()

```php
public function getRefreshToken(): ?string
```

Returns the value of a refresh token if there is one provided.
