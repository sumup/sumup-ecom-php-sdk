<?php

namespace SumUp\Services;

use SumUp\Exceptions\SumUpSDKException;
use SumUp\HttpClients\Response;
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
     * @return Response
     */
    public function getProfile(): Response
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
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function updateProfile(array $data): Response
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
     * @return Response
     */
    public function getDoingBusinessAs(): Response
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
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function updateDoingBusinessAs(array $data): Response
    {
        if (empty($data)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('payload data'));
        }
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('PUT', $path, $data, $headers);
    }
}
