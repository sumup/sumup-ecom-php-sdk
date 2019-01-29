# How to override HttpClient

## Overview

We provide two clients for dealing with HTTP communication: `\SumUp\HttpClients\SumUpCUrlClient` and `\SumUp\HttpClients\SumUpGuzzleHttpClient`. We also give the option to use your own HTTP client if you want to.

## \SumUp\HttpClients\SumUpCUrlClient

The `SumUpCUrlClient` client provides functionality for creating HTTP requests and getting responses using the PHP module [cURL](http://php.net/manual/en/book.curl.php).

## \SumUp\HttpClients\SumUpGuzzleHttpClient

The `SumUpGuzzleHttpClient` client provides functionality for creating HTTP requests and getting responses using the open-source library [Guzzle](https://packagist.org/packages/guzzlehttp/guzzle). We support **version 6.x** of the library. 

> **Note:** This library is not required for using this SDK.

## Create your own HTTP client

If you have another way of HTTP communication you can make a class that implements the interface `\SumUp\HttpClients\SumUpHttpClientInterface`. After that you can pass an instance of that class to the constructor of `\SumUp\SumUp` as second parameter. Then the SDK would use this client for every request to the SumUp's servers. 

> **Note:** you also have to **handle** all the **responses** and all the **exceptions** that might occur.
