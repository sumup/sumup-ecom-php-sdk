<?php

namespace SumUp\Services;

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
     * Returns an access token according to the grant_type.
     *
     * @param SumUpHttpClientInterface $client
     * @param ApplicationConfiguration $appConfig
     * @return null|AccessToken
     * @throws SumUpConfigurationException
     */
    public static function getToken(SumUpHttpClientInterface $client, ApplicationConfiguration $appConfig)
    {
        $accessToken = null;
        switch ($appConfig->getGrantType()) {
            case 'authorization_code':
                $accessToken = self::getTokenByCode($client, $appConfig);
                break;
            case 'client_credentials':
                $accessToken = self::getTokenByClientCredentials($client, $appConfig);
                break;
            case 'password':
                $accessToken = self::getTokenByPassword($client, $appConfig);
                break;
        }
        return $accessToken;
    }

    /**
     * Returns an access token for the grant type "authorization_code".
     *
     * @param SumUpHttpClientInterface $client
     * @param ApplicationConfiguration $appConfig
     * @return AccessToken
     */
    public static function getTokenByCode(SumUpHttpClientInterface $client, ApplicationConfiguration $appConfig)
    {
        $payload = [
            'grant_type' => "authorization_code",
            'client_id' => $appConfig->getAppId(),
            'client_secret' => $appConfig->getAppSecret(),
            'scope' => $appConfig->getScopes(),
            'code' => $appConfig->getCode()
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
     * @param ApplicationConfiguration $appConfig
     * @return AccessToken
     */
    public static function getTokenByClientCredentials(SumUpHttpClientInterface $client, ApplicationConfiguration $appConfig)
    {
        $payload = [
            'grant_type' => "client_credentials",
            'client_id' => $appConfig->getAppId(),
            'client_secret' => $appConfig->getAppSecret(),
            'scope' => $appConfig->getScopes()
        ];
        $response = $client->send( 'POST', '/token', $payload);
        $resBody = $response->getBody();
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in);
    }

    /**
     * Returns an access token for the grant type "password".
     *
     * @param SumUpHttpClientInterface $client
     * @param ApplicationConfiguration $appConfig
     * @return AccessToken
     * @throws SumUpConfigurationException
     */
    public static function getTokenByPassword(SumUpHttpClientInterface $client, ApplicationConfiguration $appConfig)
    {
        if(empty($appConfig->getUsername())) {
            throw new SumUpConfigurationException('Missing mandatory parameter "username"');
        }
        if(empty($appConfig->getPassword())) {
            throw new SumUpConfigurationException('Missing mandatory parameter "password"');
        }
        $payload = [
            'grant_type' => "password",
            'client_id' => $appConfig->getAppId(),
            'client_secret' => $appConfig->getAppSecret(),
            'scope' => $appConfig->getScopes(),
            'username' => $appConfig->getUsername(),
            'password' => $appConfig->getPassword()
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
     * @param ApplicationConfiguration $appConfig
     * @param string $refreshToken
     * @return AccessToken
     */
    public static function refreshToken(SumUpHttpClientInterface $client, ApplicationConfiguration $appConfig, $refreshToken)
    {
        $payload = [
            'grant_type' => "refresh_token",
            'client_id' => $appConfig->getAppId(),
            'client_secret' => $appConfig->getAppSecret(),
            'refresh_token' => $refreshToken,
            'scope' => $appConfig->getScopes()
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
