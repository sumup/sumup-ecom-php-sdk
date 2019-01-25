# SumUp Ecommerce PHP SDK Reference

Here is the API reference for the SumUp Ecommerce SDK for PHP.

## Core API

| Class name | Description |
|---	     |---	       |
| [\SumUp\SumUp]() | The main object that helps tie all the SDK components together. |
| [\SumUp\Application\ApplicationConfiguration]() | An entity that represents all the application's configurations. |
| [\SumUp\Authentication\AccessToken]() | An entity that represents an access token. |

## Services

| Class name | Description |
|---	     |---	       |
| [\SumUp\Services\Authorization]() | The service that manages creating and refreshing OAuth2.0 access tokens. |
| [\SumUp\Services\Checkouts]() | The service that manages checkouts. |
| [\SumUp\Services\Customers]() | The service that manages customers. |
| [\SumUp\Services\Merchant]() | The service that manages merchant's profile. |
| [\SumUp\Services\Payouts]() | The service that manages payouts. |
| [\SumUp\Services\Transactions]() | The service that manages transactions. |

## HTTP Clients and Response

| Class name | Description |
|---	     |---	       |
| [\SumUp\HttpClients\Response]() | The response object that every service returns. |
| [\SumUp\HttpClients\SumUpCUrlClient]() | The HTTP client for managing cURL requests. |
| [\SumUp\HttpClients\SumUpGuzzleHttpClient]() | The HTTP client for managing [Guzzle HTTP](https://packagist.org/packages/guzzlehttp/guzzle) requests. |
| [\SumUp\HttpClients\HttpClientsFactory]() | The factory class that creates HTTP clients. |

## Exceptions

| Class name | Description |
|---	     |---	       |
| [\SumUp\Exceptions\SumUpSDKException]() | The core exception that every other exception in the SDK inherits from. |
| [\SumUp\Exceptions\SumUpArgumentException]() | The exception for passing bad arguments to functions. |
| [\SumUp\Exceptions\SumUpAuthenticationException]() | The exception for problems with the authentication. |
| [\SumUp\Exceptions\SumUpConfigurationException]() | The exception for passing bad configurations to the SDK. |
| [\SumUp\Exceptions\SumUpConnectionException]() | The exception for problems with network communication. |
| [\SumUp\Exceptions\SumUpResponseException]() | The exception for errors in the response from a request. |
| [\SumUp\Exceptions\SumUpServerException]() | The exception for server errors. |
| [\SumUp\Exceptions\SumUpValidationException]() | The exception for server validation of the sent values. |
