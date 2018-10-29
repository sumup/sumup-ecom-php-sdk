<?php

namespace SumUp\Services;

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

    public static function getTokenByPassword(SumUpHttpClientInterface $client, ApplicationConfiguration $appConfig)
    {
        $payload = [
            'grant_type' => "password",
            'client_id' => $appConfig->getAppId(),
            'client_secret' => $appConfig->getAppSecret(),
            'username' => $appConfig->getUsername(),
            'password' => $appConfig->getPassword(),
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

    public static function refreshToken(SumUpHttpClientInterface $client, ApplicationConfiguration $appConfig, AccessToken $accessToken)
    {
        $payload = [
            'grant_type' => "refresh_token",
            'client_id' => $appConfig->getAppId(),
            'client_secret' => $appConfig->getAppSecret(),
            'refresh_token' => $accessToken->getRefreshToken(),
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
