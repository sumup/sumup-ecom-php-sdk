<?php

namespace SumUp\Services;

use SumUp\Authentication\AccessToken;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Utils\Headers;

/**
 * Class Readers
 *
 * @package SumUp\Services
 */
class Readers implements SumUpService
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
     * Readers constructor.
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
     * Delete a reader
     *
     * @param string $merchantCode Unique identifier of the merchant account.
     * @param string $id The unique identifier of the reader.
     *
     * @return \SumUp\HttpClients\Response
     */
    public function deleteReader($merchantCode, $id)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('DELETE', $path, $payload, $headers);
    }

    /**
     * Create a Reader
     *
     * @param string $merchantCode Unique identifier of the merchant account.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\HttpClients\Response
     */
    public function create($merchantCode, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('POST', $path, $payload, $headers);
    }

    /**
     * Create a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\HttpClients\Response
     */
    public function createCheckout($merchantCode, $readerId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/checkout', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('POST', $path, $payload, $headers);
    }

    /**
     * Retrieve a Reader
     *
     * @param string $merchantCode Unique identifier of the merchant account.
     * @param string $id The unique identifier of the reader.
     *
     * @return \SumUp\HttpClients\Response
     */
    public function get($merchantCode, $id)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * List Readers
     *
     * @param string $merchantCode Unique identifier of the merchant account.
     *
     * @return \SumUp\HttpClients\Response
     */
    public function list($merchantCode)
    {
        $path = sprintf('/v0.1/merchants/%s/readers', rawurlencode((string) $merchantCode));
        $payload = [];
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('GET', $path, $payload, $headers);
    }

    /**
     * Terminate a Reader Checkout
     *
     * @param string $merchantCode Merchant Code
     * @param string $readerId The unique identifier of the Reader
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\HttpClients\Response
     */
    public function terminateCheckout($merchantCode, $readerId, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s/terminate', rawurlencode((string) $merchantCode), rawurlencode((string) $readerId));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('POST', $path, $payload, $headers);
    }

    /**
     * Update a Reader
     *
     * @param string $merchantCode Unique identifier of the merchant account.
     * @param string $id The unique identifier of the reader.
     * @param array|null $body Optional request payload
     *
     * @return \SumUp\HttpClients\Response
     */
    public function update($merchantCode, $id, $body = null)
    {
        $path = sprintf('/v0.1/merchants/%s/readers/%s', rawurlencode((string) $merchantCode), rawurlencode((string) $id));
        $payload = [];
        if ($body !== null) {
            $payload = $body;
        }
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));

        return $this->client->send('PATCH', $path, $payload, $headers);
    }
}
