<?php

use PHPUnit\Framework\TestCase;
use \SumUp\Authentication\AccessToken;

class AccessTokenTest extends TestCase
{
    public function testAccessTokenWithRequiredParams()
    {
        $accessToken = new AccessToken('1a2b3c4d');

        $this->assertEquals($accessToken->getValue(), '1a2b3c4d');
    }

    public function testAccessTokenWithAllParams()
    {
        $accessToken = new AccessToken('1a2b3c4d', 'Bearer', 3600, ['payments'], '9z8y7x6w');

        $this->assertEquals($accessToken->getType(), 'Bearer');
        $this->assertEquals($accessToken->getExpiresIn(), 3600);
        $this->assertEquals($accessToken->getScopes(), ['payments']);
        $this->assertEquals($accessToken->getRefreshToken(), '9z8y7x6w');
    }
}