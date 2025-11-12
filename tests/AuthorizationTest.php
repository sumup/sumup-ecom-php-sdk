<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Application\ApplicationConfiguration;
use SumUp\HttpClients\Response;
use SumUp\Services\Authorization;
use SumUp\Tests\Doubles\FakeHttpClient;

class AuthorizationTest extends TestCase
{
    public function testApiKeyShortCircuitsHttpCalls()
    {
        $config = new ApplicationConfiguration([
            'api_key' => 'secret-api-key',
        ]);

        $httpClient = new FakeHttpClient($this->createResponse([]), true);
        $authorization = new Authorization($httpClient, $config);

        $token = $authorization->getToken();

        $this->assertSame('secret-api-key', $token->getValue());
        $this->assertSame('Bearer', $token->getType());
    }

    public function testClientCredentialsFlowMakesHttpRequest()
    {
        $config = new ApplicationConfiguration([
            'app_id' => 'app-id',
            'app_secret' => 'app-secret',
            'grant_type' => 'client_credentials',
        ]);

        $httpClient = new FakeHttpClient($this->createResponse([
            'access_token' => 'token-from-http',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
        ]));

        $authorization = new Authorization($httpClient, $config);
        $token = $authorization->getToken();

        $this->assertSame('token-from-http', $token->getValue());
        $this->assertSame('Bearer', $token->getType());
        $this->assertSame(3600, $token->getExpiresIn());

        $requests = $httpClient->getRequests();
        $this->assertCount(1, $requests);
        $this->assertSame('POST', $requests[0]['method']);
        $this->assertSame('/token', $requests[0]['url']);
        $this->assertSame('client_credentials', $requests[0]['body']['grant_type']);
        $this->assertSame('app-id', $requests[0]['body']['client_id']);
        $this->assertSame('app-secret', $requests[0]['body']['client_secret']);
        $this->assertArrayHasKey('Content-Type', $requests[0]['headers']);
    }

    private function createResponse(array $body)
    {
        return new Response(200, json_decode(json_encode($body)));
    }
}
