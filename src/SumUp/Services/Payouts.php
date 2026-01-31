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
 * Class Payouts
 *
 * @package SumUp\Services
 */
class Payouts implements SumUpService
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
     * Customers constructor.
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
     * Get a list of payouts.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int    $limit
     * @param bool   $descendingOrder
     * @param string $format
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function getPayouts(string $startDate, string $endDate, int $limit = 10, bool $descendingOrder = true, string $format = 'json'): Response
    {
        if (empty($startDate)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('start date'));
        }
        if (empty($endDate)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('end date'));
        }
        if (empty($limit) || !is_int($limit)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('limit'));
        }
        if (empty($format)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('format'));
        }
        $filters = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'limit' => $limit,
            'order' => $descendingOrder ? 'desc' : 'asc',
            'format' => $format
        ];
        $queryParams = http_build_query($filters);
        $path = '/v0.1/me/financials/payouts?' . $queryParams;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Get a list of paid out transactions.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int    $limit
     * @param bool   $descendingOrder
     * @param string $format
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function getTransactions(string $startDate, string $endDate, int $limit = 10, bool $descendingOrder = true, string $format = 'json'): Response
    {
        if (empty($startDate)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('start date'));
        }
        if (empty($endDate)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('end date'));
        }
        if (empty($limit) || !is_int($limit)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('limit'));
        }
        if (empty($format)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('format'));
        }
        $filters = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'limit' => $limit,
            'order' => $descendingOrder ? 'desc' : 'asc',
            'format' => $format
        ];
        $queryParams = http_build_query($filters);
        $path = '/v0.1/me/financials/transactions?' . $queryParams;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }
}
