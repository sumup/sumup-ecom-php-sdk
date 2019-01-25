# ApplicationConfiguration for the SumUp Ecommerce SDK for PHP

## \SumUp\Application\ApplicationConfiguration

The `\SumUp\Application\ApplicationConfiguration` entity provides all the configurations needed to work with this SDK.

## Instance Methods

### getAppId()

```php
public string getAppId()
```

Returns the app id.

### getAppSecret()

```php
public string getAppSecret()
```

Returns the app secret.

### getScopes()

```php
public array getScopes()
```

Returns an array with scopes.

### getFormattedScopes()

```php
public string getFormattedScopes()
```

Returns scopes formatted for requests.

### getCode()

```php
public string|null getCode()
```

Returns code needed for authorization with grant type `authorization_code`.

### getGrantType()

```php
public string getGrantType()
```

Returns a string with value one of: `authorization_code`, `client_credentials`, `password`.

### getUsername()

```php
public string|null getUsername()
```

Returns username needed for authorization with grant type `password`.

### getPassword()

```php
public string|null getPassword()
```

Returns password needed for authorization with grant type `password`.

### getAccessToken()

```php
public string|null getAccessToken()
```

Returns the value of an access token.

### getRefreshToken()

```php
public string|null getRefreshToken()
```

Returns the value of a refresh token.

### getForceGuzzle()

```php
public bool getForceGuzzle()
```

Returns a flag whether [GuzzleHttp](https://packagist.org/packages/guzzlehttp/guzzle) should be used instead of cURL.
