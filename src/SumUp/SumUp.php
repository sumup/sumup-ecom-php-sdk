<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
use SumUp\Application\ApplicationConfigurationInterface;
use SumUp\HttpClients\HttpClientsFactory;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\Services\Authorization;
use SumUp\Services\Checkouts;
use SumUp\Services\Customers;
use SumUp\Services\Merchant;
use SumUp\Services\Transactions;
use SumUp\Services\Payouts;
use SumUp\Services\Custom;

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

    /**
     * SumUp constructor.
     *
     * @param array $config
     * @param SumUpHttpClientInterface|null $customHttpClient
     *
     * @throws SumUpSDKException
     */
    public function __construct(array $config = [], SumUpHttpClientInterface $customHttpClient = null)
    {
        $this->appConfig = new ApplicationConfiguration($config);
        $this->client = HttpClientsFactory::createHttpClient($this->appConfig, $customHttpClient);
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->getToken();
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
     *
     * @return Authentication\AccessToken
     *
     * @throws SumUpSDKException
     */
    public function refreshToken($refreshToken = null)
    {
        if (isset($refreshToken)) {
            $rToken = $refreshToken;
        } else if (!isset($refreshToken) && !isset($this->accessToken)) {
            throw new SumUpConfigurationException('There is no refresh token');
        } else {
            $rToken = $this->accessToken->getRefreshToken();
        }
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->refreshToken($rToken);
        return $this->accessToken;
    }

    /**
     * Get the service for authorization.
     *
     * @param ApplicationConfigurationInterface|null $config
     *
     * @return Authorization
     */
    public function getAuthorizationService(ApplicationConfigurationInterface $config = null)
    {
        if (empty($config)) {
            $cfg = $this->appConfig;
        } else {
            $cfg = $config;
        }
        return new Authorization($this->client, $cfg);
    }

    /**
     * Get the service for checkouts management.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Checkouts
     */
    public function getCheckoutService(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
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
     *
     * @return Customers
     */
    public function getCustomerService(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
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
     *
     * @return Transactions
     */
    public function getTransactionService(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Transactions($this->client, $accToken);
    }

    /**
     * Get the service for merchant management.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Merchant
     */
    public function getMerchantService(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Merchant($this->client, $accToken);
    }

    /**
     * Get the service for payouts.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Payouts
     */
    public function getPayoutService(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Payouts($this->client, $accToken);
    }

    /**
     * @param AccessToken|null $accessToken
     *
     * @return Custom
     */
    public function getCustomService(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            $accToken = $accessToken;
        } else {
            $accToken = $this->accessToken;
        }
        return new Custom($this->client, $accToken);
    }
}
