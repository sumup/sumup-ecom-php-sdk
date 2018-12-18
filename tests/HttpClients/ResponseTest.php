<?php

use PHPUnit\Framework\TestCase;
use \SumUp\HttpClients\Response;
use \SumUp\Exceptions\SumUpAuthenticationException;
use \SumUp\Exceptions\SumUpValidationException;
use \SumUp\Exceptions\SumUpResponseException;

class ResponseTest extends TestCase
{
    public function testResponse()
    {
        $body = new stdClass();
        $body->checkout_id = 1;
        $body->currency = 'EUR';

        $res = new Response(200, $body);

        $this->assertEquals($res->getBody(), $body);
        $this->assertEquals($res->getHttpResponseCode(), 200);
    }

    public function testResponseAuthenticationException()
    {
        $this->expectException(
            SumUpAuthenticationException::class
        );

        $body = new stdClass();
        $body->error_message = 'invalid access token';
        $body->error_code = 'NOT_AUTHORIZED';

        new Response(200, $body);
    }

    public function testResponseValidationException()
    {
        $this->expectException(
            SumUpValidationException::class
        );

        $body = new stdClass();
        $body->message = 'Validation error';
        $body->error_code = 'MISSING';
        $body->param = "user.username";

        new Response(200, $body);
    }

    public function testResponseValidationsException()
    {
        $this->expectException(
            SumUpValidationException::class
        );

        $body = [];
        $body[0] = new stdClass();
        $body[0]->message = 'Validation error';
        $body[0]->error_code = 'MISSING';
        $body[0]->param = "username";
        $body[1] = new stdClass();
        $body[1]->message = 'Validation error';
        $body[1]->error_code = 'MISSING';
        $body[1]->param = "lastname";

        new Response(200, $body);
    }

    public function testResponseException()
    {
        $this->expectException(
            SumUpResponseException::class
        );

        $body = new stdClass();
        $body->message = 'Resource not found';

        new Response(404, $body);
    }
}