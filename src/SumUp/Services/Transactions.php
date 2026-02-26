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
     * @param string $transactionId
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function findById(string $transactionId): Response
    {
        if (empty($transactionId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction id'));
        }
        $path = '/v0.1/me/transactions?id=' . $transactionId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Get single transaction by internal ID.
     *
     * @param string $internalId
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function findByInternalId(string $internalId): Response
    {
        if (empty($internalId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('internal id'));
        }
        $path = '/v0.1/me/transactions?internal_id=' . $internalId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Get single transaction by foreign transaction id.
     *
     * @param string $foreignId
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function findByForeignId(string $foreignId): Response
    {
        if (empty($foreignId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('foreign transaction id'));
        }
        $path = '/v0.1/me/transactions?foreign_transaction_id=' . $foreignId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Get single transaction by transaction code.
     *
     * @param string $transactionCode
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function findByTransactionCode(string $transactionCode): Response
    {
        if (empty($transactionCode)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction code'));
        }
        $path = '/v0.1/me/transactions?transaction_code=' . $transactionCode;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Get a list of transactions.
     *
     * @param array $filters
     *
     * @return Response
     */
    public function getTransactionHistory(array $filters = []): Response
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
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Refund a transaction partially or fully.
     *
     * @param string $transactionId
     * @param string|null $amount
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function refund(string $transactionId, ?string $amount = null): Response
    {
        if (empty($transactionId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction id'));
        }
        $payload = [];
        if (!empty($amount)) {
            $payload = [
                'amount' => $amount
            ];
        }
        $path = '/v0.1/me/refund/' . $transactionId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('POST', $path, $payload, $headers);
    }

    /**
     * Get a receipt for a transaction.
     *
     * @param string $transactionId
     * @param string $merchantId
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function getReceipt(string $transactionId, string $merchantId): Response
    {
        if (empty($transactionId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('transaction id'));
        }
        if (empty($merchantId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('merchant id'));
        }
        $queryParams = http_build_query(['mid' => $merchantId]);
        $path = '/v1.0/receipts/' . $transactionId . '?' . $queryParams;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }
}
