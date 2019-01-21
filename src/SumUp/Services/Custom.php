<?php

namespace SumUp\Services;

use SumUp\Exceptions\SumUpArgumentException;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Utils\Headers;

/**
 * Class Custom
 *
 * @package SumUp\Services
 */
class Custom implements SumUpService
{
    /**
     * Allowed HTTP methods.
     */
    const HTTP_METHODS = ['GET', 'POST', 'PUT', 'DELETE'];

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
     * Custom constructor.
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
     * Make custom request.
     *
     * @param string     $method
     * @param string     $relativePath
     * @param array|null $payload
     *
     * @return mixed|\SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function request($method, $relativePath, $payload = null)
    {
        if (!in_array($method, $this::HTTP_METHODS)) {
            $message = "Not allowed method provided: $method. Allowed values: " . implode(', ', $this::HTTP_METHODS) . '.';
            throw new SumUpArgumentException($message);
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send( $method, $relativePath, $payload, $headers);
    }
}
