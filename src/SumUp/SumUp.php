<?php

namespace SumUp;

use SumUp\Application\ApplicationConfiguration;
use SumUp\Application\ApplicationConfigurationInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\HttpClients\HttpClientsFactory;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Services\Authorization;
use SumUp\Services\Checkouts;
use SumUp\Services\Custom;
use SumUp\Services\Customers;
use SumUp\Services\Members;
use SumUp\Services\Memberships;
use SumUp\Services\Merchant;
use SumUp\Services\Merchants;
use SumUp\Services\Payouts;
use SumUp\Services\Readers;
use SumUp\Services\Receipts;
use SumUp\Services\Roles;
use SumUp\Services\Subaccounts;
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
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @var SumUpHttpClientInterface
     */
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
     * @return AccessToken
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
     * @return AccessToken
     *
     * @throws SumUpSDKException
     */
    public function refreshToken($refreshToken = null)
    {
        if (isset($refreshToken)) {
            $rToken = $refreshToken;
        } elseif (!isset($refreshToken) && !isset($this->accessToken)) {
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
     * Resolve the access token that should be used for a service.
     *
     * @param AccessToken|null $accessToken
     *
     * @return AccessToken
     */
    protected function resolveAccessToken(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            return $accessToken;
        }

        return $this->accessToken;
    }

    /**
     * Get the service for checkouts.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Checkouts
     */
    public function getCheckoutService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Checkouts($this->client, $token);
    }

    /**
     * Get the service for customers.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Customers
     */
    public function getCustomerService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Customers($this->client, $token);
    }

    /**
     * Get the service for members.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Members
     */
    public function getMembersService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Members($this->client, $token);
    }

    /**
     * Get the service for memberships.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Memberships
     */
    public function getMembershipsService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Memberships($this->client, $token);
    }

    /**
     * Get the service for merchant.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Merchant
     */
    public function getMerchantService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Merchant($this->client, $token);
    }

    /**
     * Get the service for merchants.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Merchants
     */
    public function getMerchantsService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Merchants($this->client, $token);
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
        $token = $this->resolveAccessToken($accessToken);

        return new Payouts($this->client, $token);
    }

    /**
     * Get the service for readers.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Readers
     */
    public function getReadersService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Readers($this->client, $token);
    }

    /**
     * Get the service for receipts.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Receipts
     */
    public function getReceiptsService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Receipts($this->client, $token);
    }

    /**
     * Get the service for roles.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Roles
     */
    public function getRolesService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Roles($this->client, $token);
    }

    /**
     * Get the service for subaccounts.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Subaccounts
     */
    public function getSubaccountsService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Subaccounts($this->client, $token);
    }

    /**
     * Get the service for transactions.
     *
     * @param AccessToken|null $accessToken
     *
     * @return Transactions
     */
    public function getTransactionService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Transactions($this->client, $token);
    }

    /**
     * @param AccessToken|null $accessToken
     *
     * @return Custom
     */
    public function getCustomService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Custom($this->client, $token);
    }
}
