# SumUpAuthenticationException for the SumUp Ecommerce SDK for PHP

Represents an exception thrown by any service in the SDK.

## \SumUp\Exceptions\SumUpAuthenticationException

A `SumUpAuthenticationException` is thrown when there are problems with the authentication. For example if the OAuth token is invalid or expired.

## Instance Methods

`SumUpAuthenticationException` extends from the base `\SumUp\Exceptions\SumUpSDKException` class, so `getCode()` and `getMessage()` are available by default.
