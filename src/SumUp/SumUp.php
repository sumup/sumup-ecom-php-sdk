<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
use SumUp\Application\ApplicationConfigurationInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Services\Authorization;
use SumUp\Services\Checkouts;
use SumUp\Services\Customers;
use SumUp\Services\Transactions;

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
        $authorizationService = new Authorization($this->appConfig);
        $this->accessToken = $authorizationService->getToken($this->client, $this->appConfig);
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
        $authorizationService = new Authorization($this->appConfig);
        $this->accessToken = $authorizationService->refreshToken($this->client, $rToken);
        return $this->accessToken;
    }

    /**
     * Get the service for authorization.
     *
     * @param ApplicationConfigurationInterface|null $config
     * @return Authorization
     * @throws \Exception
     */
    public function getAuthorizationService(ApplicationConfigurationInterface $config = null)
    {
        if(empty($config)) {
            $cfg = $this->appConfig;
        } else {
            $cfg = $config;
        }
        return new Authorization($cfg);
    }

    /**
     * Get the service for checkouts management.
     *
     * @param AccessToken|null $accessToken
     * @return Checkouts
     */
    public function getCheckoutService(AccessToken $accessToken = null)
    {
        if(!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Checkouts($this->client, $accToken);
    }

    /**
     * Get the service for customers management.
     *
     * @param AccessToken|null $accessToken
     * @return Customers
     */
    public function getCustomerService(AccessToken $accessToken = null)
    {
        if(!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Customers($this->client, $accToken);
    }

    /**
     * Get the service for transactions management.
     *
     * @param AccessToken|null $accessToken
     * @return Transactions
     */
    public function getTransactionService(AccessToken $accessToken = null)
    {
        if(!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Transactions($this->client, $accToken);
    }
}
