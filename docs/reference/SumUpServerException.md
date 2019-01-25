# SumUpServerException for the SumUp Ecommerce SDK for PHP

Represents an exception thrown by any service in the SDK.

## \SumUp\Exceptions\SumUpServerException

A `SumUpServerException` is thrown when there are 5xx http errors. For example if there is an error `500 Internal Server Error`.

## Instance Methods

`SumUpServerException` extends from the base `\SumUp\Exceptions\SumUpSDKException` class, so `getCode()` and `getMessage()` are available by default.
