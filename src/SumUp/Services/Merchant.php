<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;

/**
 * Class Merchant
 *
 * @package SumUp\Services
 */
class Merchant implements SumUpService
{
    /**
     * The client for the http communication.
     *
     * @var SumUpHttpClientInterface
     */
    protected $client;

    /**
     * The access token needed for authentication for the services.
     *
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * Merchant constructor.
     *
     * @param SumUpHttpClientInterface $client
     * @param AccessToken $accessToken
     */
    public function __construct(SumUpHttpClientInterface $client, AccessToken $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Retrieve a profile
     *
     * @param array $queryParams Optional query string parameters
     *
     * @return \SumUp\HttpClients\Response
     *
     * @deprecated
     */
    public function get($queryParams = [])
    {
        $path = '/v0.1/me';
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * Retrieve DBA
     *
     *
     * @return \SumUp\HttpClients\Response
     *
     * @deprecated
     */
    public function getDoingBusinessAs()
    {
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * Retrieve a merchant profile
     *
     *
     * @return \SumUp\HttpClients\Response
     *
     * @deprecated
     */
    public function getMerchantProfile()
    {
        $path = '/v0.1/me/merchant-profile';
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * Retrieve a personal profile
     *
     *
     * @return \SumUp\HttpClients\Response
     *
     * @deprecated
     */
    public function getPersonalProfile()
    {
        $path = '/v0.1/me/personal-profile';
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('GET', $path, $payload, $headers);
    }
}
