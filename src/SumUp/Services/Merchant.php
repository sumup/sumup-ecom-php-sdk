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
     */
    public function getProfile()
    {
        $path = '/v0.1/me/merchant-profile';
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
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
     */
    public function updateProfile(array $data)
    {
        if(!isset($data)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('payload data'));
        }
        $path = '/v0.1/me/merchant-profile';
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
        return $this->client->send('PUT', $path, $data, $headers);
    }

    /**
     * Get data for going business as.
     *
     * @return \SumUp\HttpClients\Response
     */
    public function getDoingBusinessAs()
    {
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
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
     */
    public function updateDoingBusinessAs(array $data)
    {
        if(!isset($data)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('payload data'));
        }
        $path = '/v0.1/me/merchant-profile/doing-business-as';
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
        return $this->client->send('PUT', $path, $data, $headers);
    }
}