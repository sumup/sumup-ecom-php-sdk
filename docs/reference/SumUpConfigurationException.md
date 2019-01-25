# SumUpConfigurationException for the SumUp Ecommerce SDK for PHP

Represents an exception thrown by any service in the SDK.

## \SumUp\Exceptions\SumUpConfigurationException

A `SumUpConfigurationException` is thrown when there is a problem with some configuration parameters mostly when initializing the main `\SumUp\SumUp` instance.

> **Note:** This exception is helpful during development but in most cases there is no need to be handled for production code.

## Instance Methods

`SumUpConfigurationException` extends from the base `\SumUp\Exceptions\SumUpSDKException` class, so `getCode()` and `getMessage()` are available by default.
