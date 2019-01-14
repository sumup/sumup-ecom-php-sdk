<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpArgumentException;
use SumUp\Utils\ExceptionMessages;
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
     * Checkouts constructor.
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
     * Get merchant's profile.
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getProfile()
    {
        $path = '/v0.1/me/merchant-profile';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Update merchant's profile.
     *
     * @param array $data
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function updateProfile(array $data)
    {
        if (empty($data)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('payload data'));
        }
        $path = '/v0.1/me/merchant-profile';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('PUT', $path, $data, $headers);
    }

    /**
     * Get data for doing business as.
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getDoingBusinessAs()
    {
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Update data for doing business as.
     *
     * @param array $data
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function updateDoingBusinessAs(array $data)
    {
        if (empty($data)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('payload data'));
        }
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('PUT', $path, $data, $headers);
    }
}
