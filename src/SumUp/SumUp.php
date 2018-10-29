<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
use SumUp\Services\Authorization;

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
     * @var ApplicationConfiguration
     */
    protected $appConfig;

    /**
     * The access token that holds the data from the response.
     *
     * @var Authentication\AccessToken
     */
    protected $accessToken;

    /** @var HttpClients\SumUpGuzzleHttpClient */
    protected $client;

    public function __construct(array $config = [])
    {
        $this->appConfig = new ApplicationConfiguration($config);
        $this->client = new HttpClients\SumUpGuzzleHttpClient($this->appConfig->getBaseURL());
        $this->accessToken = Authorization::getToken($this->client, $this->appConfig);
    }

    /**
     * @return \AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return \AccessToken
     * @throws \Exception
     */
    public function refreshToken()
    {
        if(!isset($this->accessToken)) {
            // TODO: throw custom error
            throw new \Exception('There is no refresh token');
        }
        $this->accessToken = Authorization::refreshToken($this->client, $this->appConfig, $this->accessToken);
        return $this->accessToken;
    }
}
