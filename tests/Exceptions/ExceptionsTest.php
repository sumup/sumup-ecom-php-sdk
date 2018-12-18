<?php

use PHPUnit\Framework\TestCase;
use \SumUp\Exceptions\SumUpValidationException;

class ExceptionsTest extends TestCase
{
    public function testValidationException()
    {
        $err = new SumUpValidationException(['username', 'lastname', 'address'], 401, null);

        $this->assertInstanceOf(SumUpValidationException::class, $err);
        $this->assertEquals($err->getCode(), 401);
        $this->assertEquals($err->getMessage(), 'Validation error in: username, lastname, address');
        $this->assertEquals($err->getInvalidFields(), ['username', 'lastname', 'address']);
    }
}