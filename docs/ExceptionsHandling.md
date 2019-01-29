# Exceptions handling

Exceptions handling is an important part of our code. We pay attention to this detail and **we recommend to wrap every statement from this SDK with a `try {} catch() {}` clause**.

You should at least handle `\SumUp\Exceptions\SumUpSDKException` exception but if you want you can handle all sorts of exceptions.

```php
try {
    $sumup = new \SumUp\SumUp($config);
} catch (\SumUp\Exceptions\SumUpAuthenticationException $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
} catch (\SumUp\Exceptions\SumUpResponseException $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
} catch (\SumUp\Exceptions\SumUpSDKException $e) {
    echo $e->getCode() . ': ' . $e->getMessage();
}
```

More information about the exceptions can be found in [the reference](https://github.com/sumup/sumup-ecom-php-sdk/tree/master/docs#exceptions).
