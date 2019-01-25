# SumUpResponseException for the SumUp Ecommerce SDK for PHP

Represents an exception thrown by any service in the SDK.

## \SumUp\Exceptions\SumUpResponseException

A `SumUpResponseException` is thrown when there are 4xx http errors. For example if there is an error `404 Not Found`.

## Instance Methods

`SumUpResponseException` extends from the base `\SumUp\Exceptions\SumUpSDKException` class, so `getCode()` and `getMessage()` are available by default.
