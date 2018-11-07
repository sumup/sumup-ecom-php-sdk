<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;

/**
 * Class Transactions
 *
 * @package SumUp\Services
 */
class Transactions implements SumUpService
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
        // TODO: throw an error if the params are not passed or are null
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Get single transaction by transaction ID.
     *
     * @param $transactionId
     * @return \SumUp\HttpClients\Response
     */
    public function findById($transactionId)
    {
        // TODO: throw an error if the param is not passed or is null
        $path = '/v0.1/me/transactions?id=' . $transactionId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get single transaction by internal ID.
     *
     * @param $internalId
     * @return \SumUp\HttpClients\Response
     */
    public function findByInternalId($internalId)
    {
        // TODO: throw an error if the param is not passed or is null
        $path = '/v0.1/me/transactions?internal_id=' . $internalId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get single transaction by transaction code.
     *
     * @param $transactionCode
     * @return \SumUp\HttpClients\Response
     */
    public function findByTransactionCode($transactionCode)
    {
        // TODO: throw an error if the param is not passed or is null
        $path = '/v0.1/me/transactions?transaction_code=' . $transactionCode;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get a list of transactions.
     *
     * @param array $filters
     * @return \SumUp\HttpClients\Response
     */
    public function getTransactionHistory($filters = [])
    {
        $filters = array_merge([
            'order' => 'ascending',
            'limit' => 10,
            'user_id' => null,
            'users' => [],
            'statuses' => [],
            'payment_types' => [],
            'types' => [],
            'changes_since' => null,
            'newest_time' => null,
            'newest_ref' => null,
            'oldest_time' => null,
            'oldest_ref' => null,
        ], $filters);

        $queryParams = http_build_query($filters);
        /**
         * Remove index from the [] because the server doesn't parses the data correctly.
         */
        $queryParams = preg_replace('/%5B[0-9]+%5D/', '%5B%5D', $queryParams);

        $path = '/v0.1/me/transactions/history?' . $queryParams;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Refund a transaction partially or fully.
     *
     * @param $transactionId
     * @param $amount
     * @return \SumUp\HttpClients\Response
     */
    public function refund($transactionId, $amount)
    {
        // TODO: throw an error if the param is not passed or is null
        $payload = [
            'amount' => $amount
        ];
        $path = '/v0.1/me/refund/' . $transactionId;
        return $this->client->send('POST', $path, $payload, $this->accessToken->getValue());
    }

    /**
     * Get a receipt for a transaction.
     *
     * @param $transactionId
     * @param $merchantId
     * @return \SumUp\HttpClients\Response
     */
    public function getReceipt($transactionId, $merchantId)
    {
        // TODO: throw an error if the param is not passed or is null
        $queryParams = http_build_query(['mid' => $merchantId]);
        $path = '/v1.0/receipts/' . $transactionId . '?' . $queryParams;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

}