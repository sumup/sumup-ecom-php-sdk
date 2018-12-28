<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;
USE SumUp\Exceptions\SumUpArgumentException;
use SumUp\Utils\ExceptionMessages;

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
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Get single transaction by transaction ID.
     *
     * @param $transactionId
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function findById($transactionId)
    {
        if(empty($transactionId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction id'));
        }
        $path = '/v0.1/me/transactions?id=' . $transactionId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get single transaction by internal ID.
     *
     * @param $internalId
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function findByInternalId($internalId)
    {
        if(empty($internalId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('internal id'));
        }
        $path = '/v0.1/me/transactions?internal_id=' . $internalId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get single transaction by transaction code.
     *
     * @param $transactionCode
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function findByTransactionCode($transactionCode)
    {
        if(empty($transactionCode)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction code'));
        }
        $path = '/v0.1/me/transactions?transaction_code=' . $transactionCode;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get a list of transactions.
     *
     * @param array $filters
     *
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
         * Remove index from the [] because the server doesn't support it this way.
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
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function refund($transactionId, $amount)
    {
        if(empty($transactionId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction id'));
        }
        if(empty($amount)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('amount'));
        }
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
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function getReceipt($transactionId, $merchantId)
    {
        if(empty($transactionId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction id'));
        }
        if(empty($merchantId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('merchant id'));
        }
        $queryParams = http_build_query(['mid' => $merchantId]);
        $path = '/v1.0/receipts/' . $transactionId . '?' . $queryParams;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

}