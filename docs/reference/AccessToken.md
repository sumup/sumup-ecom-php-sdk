# AccessToken for the SumUp Ecommerce SDK for PHP

Requests to the SumUp's API need to have an access token sent with them to identify the application and the user. The `SumUp\Authentication\AccessToken` entity represents an access token.

## SumUp\Authentication\AccessToken

Every time you create an instance of `SumUp\SumUp` you get an `AccessToken` that can be used to request other resources.

## Instance Methods

### getValue()

```php
public string getValue()
```

Returns the actual value of the access token as a string.

### getType()

```php
public string getType()
```

Returns the type of authentication that the access token should be used for.

### getExpiresIn()

```php
public int getExpiresIn()
```

Returns the total number of seconds the access token is valid for.

### getScopes()

```php
public array getScopes()
```

Returns the scopes for which the access token is valid.

### getRefreshToken()

```php
public string|null getRefreshToken()
```

Returns the value of a refresh token if there is one provided.
