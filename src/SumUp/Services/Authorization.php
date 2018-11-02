<?php

namespace SumUp\Services;

use SumUp\Application\ApplicationConfigurationInterface;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Application\ApplicationConfiguration;
use SumUp\Authentication\AccessToken;

/**
 * Class Authorization
 *
 * @package SumUp\Services
 */
class Authorization implements SumUpService
{
    /**
     * The application's configuration.
     *
     * @var ApplicationConfiguration
     */
    protected $appConfig;

    public function __construct(ApplicationConfigurationInterface $config)
    {
        if(empty($config) || !($config instanceof ApplicationConfigurationInterface)) {
            throw new \Exception('Missing mandatory argument of type "ApplicationConfigurationInterface"');
        }
        $this->appConfig = $config;
    }

    /**
     * Returns an access token according to the grant_type.
     *
     * @param SumUpHttpClientInterface $client
     * @return null|AccessToken
     * @throws SumUpConfigurationException
     */
    public function getToken(SumUpHttpClientInterface $client)
    {
        $accessToken = null;
        switch ($this->appConfig->getGrantType()) {
            case 'authorization_code':
                $accessToken = $this->getTokenByCode($client);
                break;
            case 'client_credentials':
                $accessToken = $this->getTokenByClientCredentials($client);
                break;
            case 'password':
                $accessToken = $this->getTokenByPassword($client);
                break;
        }
        return $accessToken;
    }

    /**
     * Returns an access token for the grant type "authorization_code".
     *
     * @param SumUpHttpClientInterface $client
     * @return AccessToken
     */
    public function getTokenByCode(SumUpHttpClientInterface $client)
    {
        $payload = [
            'grant_type' => "authorization_code",
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'scope' => $this->appConfig->getScopes(),
            'code' => $this->appConfig->getCode()
        ];
        $response = $client->send( 'POST', '/token', $payload);
        $resBody = $response->getBody();
        $scopes = [];
        if(!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }

    /**
     * Returns an access token for the grant type "client_credentials".
     *
     * @param SumUpHttpClientInterface $client
     * @return AccessToken
     */
    public function getTokenByClientCredentials(SumUpHttpClientInterface $client)
    {
        $payload = [
            'grant_type' => "client_credentials",
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'scope' => $this->appConfig->getScopes()
        ];
        $response = $client->send( 'POST', '/token', $payload);
        $resBody = $response->getBody();
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in);
    }

    /**
     * Returns an access token for the grant type "password".
     *
     * @param SumUpHttpClientInterface $client
     * @return AccessToken
     * @throws SumUpConfigurationException
     */
    public function getTokenByPassword(SumUpHttpClientInterface $client)
    {
        if(empty($this->appConfig->getUsername())) {
            throw new SumUpConfigurationException('Missing mandatory parameter "username"');
        }
        if(empty($this->appConfig->getPassword())) {
            throw new SumUpConfigurationException('Missing mandatory parameter "password"');
        }
        $payload = [
            'grant_type' => "password",
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'scope' => $this->appConfig->getScopes(),
            'username' => $this->appConfig->getUsername(),
            'password' => $this->appConfig->getPassword()
        ];
        $response = $client->send( 'POST', '/token', $payload);
        $resBody = $response->getBody();
        $scopes = [];
        if(!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }

    /**
     * Refresh access token.
     *
     * @param SumUpHttpClientInterface $client
     * @param string $refreshToken
     * @return AccessToken
     */
    public function refreshToken(SumUpHttpClientInterface $client, $refreshToken)
    {
        $payload = [
            'grant_type' => "refresh_token",
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'refresh_token' => $refreshToken,
            'scope' => $this->appConfig->getScopes()
        ];
        $response = $client->send( 'POST', '/token', $payload);
        $resBody = $response->getBody();
        $scopes = [];
        if(!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }
}
