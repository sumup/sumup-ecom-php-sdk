<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Services\Authorization;
use SumUp\Services\Checkouts;

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
     * Returns the access token.
     *
     * @return Authentication\AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Refresh the access token.
     *
     * @param string $refreshToken
     * @return Authentication\AccessToken
     * @throws \Exception
     */
    public function refreshToken($refreshToken = null)
    {
        if(isset($refreshToken)) {
            $rToken = $refreshToken;
        } else if(!isset($refreshToken) && !isset($this->accessToken)) {
            throw new SumUpConfigurationException('There is no refresh token');
        } else {
            $rToken = $this->accessToken->getRefreshToken();
        }
        $this->accessToken = Authorization::refreshToken($this->client, $this->appConfig, $rToken);
        return $this->accessToken;
    }

    public function getServiceCheckouts(AccessToken $accessToken = null)
    {
        if(!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Checkouts($this->client, $accToken);
    }
}
