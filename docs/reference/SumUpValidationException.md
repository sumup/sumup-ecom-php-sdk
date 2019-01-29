# SumUpValidationException for the SumUp Ecommerce SDK for PHP

Represents an exception thrown by any service in the SDK.

## \SumUp\Exceptions\SumUpValidationException

A `SumUpValidationException` is thrown when there are values sent to the server that don't comply with the server's validations.

## Instance Methods

`SumUpValidationException` extends from the base `\SumUp\Exceptions\SumUpSDKException` class, so `getCode()` and `getMessage()` are available by default.

It also has a method `getInvalidFields()` that returns an array with all the incorrect fields.
