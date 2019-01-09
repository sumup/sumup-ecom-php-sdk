<?php

namespace SumUp\Services;

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
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getPayouts($startDate, $endDate, $limit = 10, $descendingOrder = true, $format = 'json')
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
        if (empty($descendingOrder)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('order'));
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
        return $this->client->send('GET', $path, null, $headers);
    }

    /**
     * Get a list of payed out transactions.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int    $limit
     * @param bool   $descendingOrder
     * @param string $format
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getTransactions($startDate, $endDate, $limit = 10, $descendingOrder = true, $format = 'json')
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
        if (empty($descendingOrder)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('order'));
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
        return $this->client->send('GET', $path, null, $headers);
    }
}
