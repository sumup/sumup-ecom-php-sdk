<?php

namespace SumUp\Services;

use SumUp\Application\ApplicationConfigurationInterface;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Exceptions\SumUpArgumentException;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Application\ApplicationConfiguration;
use SumUp\Authentication\AccessToken;
use SumUp\Utils\ExceptionMessages;
use SumUp\Utils\Headers;

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

    /**
     * Authorization constructor.
     *
     * @param ApplicationConfigurationInterface $config
     */
    public function __construct(ApplicationConfigurationInterface $config)
    {
        $this->appConfig = $config;
    }

    /**
     * Returns an access token according to the grant_type.
     *
     * @param SumUpHttpClientInterface $client
     *
     * @return null|AccessToken
     *
     * @throws SumUpConfigurationException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getToken(SumUpHttpClientInterface $client)
    {
        $accessToken = null;
        if (!empty($this->appConfig->getAccessToken())) {
            $accessToken = new AccessToken(
                $this->appConfig->getAccessToken(),
                '',
                0,
                $this->appConfig->getScopes(),
                $this->appConfig->getRefreshToken()
            );
        } else if (!empty($this->appConfig->getRefreshToken())) {
            $accessToken = new AccessToken(
                '',
                '',
                0,
                $this->appConfig->getScopes(),
                $this->appConfig->getRefreshToken()
            );
        } else {
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
        }
        return $accessToken;
    }

    /**
     * Returns an access token for the grant type "authorization_code".
     *
     * @param SumUpHttpClientInterface $client
     *
     * @return AccessToken
     *
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getTokenByCode(SumUpHttpClientInterface $client)
    {
        $payload = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'scope' => $this->appConfig->getFormattedScopes(),
            'code' => $this->appConfig->getCode()
        ];
        $headers = Headers::getStandardHeaders();
        $response = $client->send( 'POST', '/token', $payload, $headers);
        $resBody = $response->getBody();
        $scopes = [];
        if (!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }

    /**
     * Returns an access token for the grant type "client_credentials".
     *
     * @param SumUpHttpClientInterface $client
     *
     * @return AccessToken
     *
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getTokenByClientCredentials(SumUpHttpClientInterface $client)
    {
        $payload = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'scope' => $this->appConfig->getFormattedScopes()
        ];
        $headers = Headers::getStandardHeaders();
        $response = $client->send( 'POST', '/token', $payload, $headers);
        $resBody = $response->getBody();
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in);
    }

    /**
     * Returns an access token for the grant type "password".
     *
     * @param SumUpHttpClientInterface $client
     *
     * @return AccessToken
     *
     * @throws SumUpConfigurationException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getTokenByPassword(SumUpHttpClientInterface $client)
    {
        if (empty($this->appConfig->getUsername())) {
            throw new SumUpConfigurationException(ExceptionMessages::getMissingParamMsg('username'));
        }
        if (empty($this->appConfig->getPassword())) {
            throw new SumUpConfigurationException(ExceptionMessages::getMissingParamMsg("password"));
        }
        $payload = [
            'grant_type' => 'password',
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'scope' => $this->appConfig->getFormattedScopes(),
            'username' => $this->appConfig->getUsername(),
            'password' => $this->appConfig->getPassword()
        ];
        $headers = Headers::getStandardHeaders();
        $response = $client->send( 'POST', '/token', $payload, $headers);
        $resBody = $response->getBody();
        $scopes = [];
        if (!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }

    /**
     * Refresh access token.
     *
     * @param SumUpHttpClientInterface $client
     * @param string $refreshToken
     *
     * @return AccessToken
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function refreshToken(SumUpHttpClientInterface $client, $refreshToken)
    {
        if (empty($refreshToken)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('refresh token'));
        }
        $payload = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->appConfig->getAppId(),
            'client_secret' => $this->appConfig->getAppSecret(),
            'refresh_token' => $refreshToken,
            'scope' => $this->appConfig->getFormattedScopes()
        ];
        $headers = Headers::getStandardHeaders();
        $response = $client->send( 'POST', '/token', $payload, $headers);
        $resBody = $response->getBody();
        $scopes = [];
        if (!empty($resBody->scope)) {
            $scopes = explode(' ', $resBody->scope);
        }
        return new AccessToken($resBody->access_token, $resBody->token_type, $resBody->expires_in, $scopes, $resBody->refresh_token);
    }
}
