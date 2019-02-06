# SumUp Ecommerce PHP SDK Reference

Here is the API reference for the SumUp Ecommerce SDK for PHP.

## Core API

| Class name | Description |
|---	     |---	       |
| [\SumUp\SumUp](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUp.md) | The main object that helps tie all the SDK components together. |
| [\SumUp\Application\ApplicationConfiguration](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/ApplicationConfiguration.md) | An entity that represents all the application's configurations. |
| [\SumUp\Authentication\AccessToken](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/AccessToken.md) | An entity that represents an access token. |
| [\SumUp\HttpClients\Response](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Response.md) | The response object that every service returns. |

## Services

| Class name | Description |
|---	     |---	       |
| [\SumUp\Services\Authorization](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Authorization.md) | The service that manages creating and refreshing OAuth2.0 access tokens. |
| [\SumUp\Services\Checkouts](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Checkouts.md) | The service that manages checkouts. |
| [\SumUp\Services\Custom](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Custom.md) | The generic service that can be used for endpoints that are not part of the core functionality. |
| [\SumUp\Services\Customers](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Customers.md) | The service that manages customers. |
| [\SumUp\Services\Merchant](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Merchant.md) | The service that manages merchant's profile. |
| [\SumUp\Services\Payouts](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Payouts.md) | The service that manages payouts. |
| [\SumUp\Services\Transactions](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/Transactions.md) | The service that manages transactions. |

<!-- ## HTTP Clients and Response

| Class name | Description |
|---	     |---	       |
| [\SumUp\HttpClients\SumUpCUrlClient]() | The HTTP client for managing cURL requests. |
| [\SumUp\HttpClients\SumUpGuzzleHttpClient]() | The HTTP client for managing [Guzzle HTTP](https://packagist.org/packages/guzzlehttp/guzzle) requests. |
| [\SumUp\HttpClients\HttpClientsFactory]() | The factory class that creates HTTP clients. | -->

## Exceptions

| Class name | Description |
|---	     |---	       |
| [\SumUp\Exceptions\SumUpSDKException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpSDKException.md) | The core exception that every other exception in the SDK inherits from. |
| [\SumUp\Exceptions\SumUpArgumentException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpArgumentException.md) | The exception for passing bad arguments to functions. |
| [\SumUp\Exceptions\SumUpAuthenticationException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpAuthenticationException.md) | The exception for problems with the authentication. |
| [\SumUp\Exceptions\SumUpConfigurationException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpConfigurationException.md) | The exception for passing bad configurations to the SDK. |
| [\SumUp\Exceptions\SumUpConnectionException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpConnectionException.md) | The exception for problems with network communication. |
| [\SumUp\Exceptions\SumUpResponseException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpResponseException.md) | The exception for errors in the response from a request. |
| [\SumUp\Exceptions\SumUpServerException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpServerException.md) | The exception for server errors. |
| [\SumUp\Exceptions\SumUpValidationException](https://github.com/sumup/sumup-ecom-php-sdk/blob/master/docs/reference/SumUpValidationException.md) | The exception for server validation of the sent values. |
