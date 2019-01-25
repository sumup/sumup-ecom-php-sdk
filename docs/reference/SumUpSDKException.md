# SumUpSDKException for the SumUp Ecommerce SDK for PHP

Represents an exception thrown by the SDK.

## \SumUp\Exceptions\SumUpSDKException

A `\SumUpSDKException` is thrown when something goes wrong. For example if there is a network problem or if your access token has expired.

This is the basic exception that every other exception in the SDK inherits from.

## Instance Methods

`SumUpSDKException` extends from the base `\Exception` class, so `getCode()` and `getMessage()` are available by default.
