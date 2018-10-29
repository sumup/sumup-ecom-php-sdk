<?php

namespace SumUp;

use SumUp\Application\Application;
use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;

/**
 * Class SumUp
 *
 * @package SumUp
 */
class SumUp
{
    /**
     * The application's configuration.
     *
     * @var Application
     */
    protected $app;

    /**
     * The access token that holds the data from the response.
     *
     * @var Authentication\AccessToken
     */
    protected $access_token;

    /** @var HttpClients\SumUpGuzzleHttpClient */
    protected $client;

    protected $allowedTokenTypes = ['authorization_code', 'client_credentials', 'password'];

    public function __construct(array $config = [])
    {
        $config = array_merge([
            'app_id' => null,
            'app_secret' => null,
            'grant_type' => 'authorization_code',
            'scopes' => [],
            'code' => null,
            'username' => null,
            'password' => null,

            'base_uri' => 'https://api.sumup.com'
        ], $config);

        $this->client = new HttpClients\SumUpGuzzleHttpClient($config['base_uri']);
        $this->app = new Application($config['app_id'], $config['app_secret'], $config['scopes']);

        switch ($config['grant_type']) {
            case 'authorization_code':
                $this->getTokenByCode($config['code']);
                break;
            case 'client_credentials':
                $this->getToken();
                break;
            case 'password':
                $this->getTokenByPassword($config['username'], $config['password']);
                break;
        }
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    private function getToken()
    {
        $payload = [
            'grant_type' => "client_credentials",
            'client_id' => $this->app->getClientId(),
            'client_secret' => $this->app->getClientSecret(),
            'scope' => $this->app->getScopes()
        ];
        $response = $this->client->send( 'POST', '/token', $payload);

        echo 'Response: ' . $response->getHttpResponseCode() . '<br/>';

        $resBody = $response->getBody();
        $this->access_token = new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in);
    }

    private function getTokenByCode($code)
    {
        $payload = [
            'grant_type' => "authorization_code",
            'client_id' => $this->app->getClientId(),
            'client_secret' => $this->app->getClientSecret(),
            'scope' => $this->app->getScopes(),
            'code' => $code
        ];
        $response = $this->client->send( 'POST', '/token', $payload);

        echo 'Response: ' . $response->getHttpResponseCode() . '<br/>';

        $resBody = $response->getBody();
        $scopes = [];
        if(!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        $this->access_token = new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }

    private function getTokenByPassword($username, $password) {
        $payload = [
            'grant_type' => "password",
            'client_id' => $this->app->getClientId(),
            'client_secret' => $this->app->getClientSecret(),
            'username' => $username,
            'password' => $password,
            'scope' => $this->app->getScopes()
        ];
        $response = $this->client->send( 'POST', '/token', $payload);

        echo 'Response: ' . $response->getHttpResponseCode() . '<br/>';

        $resBody = $response->getBody();
        $scopes = [];
        if(!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        $this->access_token = new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }
}
