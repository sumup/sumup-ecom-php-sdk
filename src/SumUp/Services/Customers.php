<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Exceptions\SumUpArgumentException;
use SumUp\Utils\ExceptionMessages;
use SumUp\Utils\Headers;

/**
 * Class Customers
 *
 * @package SumUp\Services
 */
class Customers implements SumUpService
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
     * Create new customer.
     *
     * @param $customerId
     * @param array $customerDetails
     * @param array $customerAddress
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function create($customerId, array $customerDetails = [], array $customerAddress = [])
    {
        if (empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }

        $details = array_merge([
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'phone' => null
        ], $customerDetails);
        $details = array_filter($details);

        $address = array_merge([
            'city' => null,
            'country' => null,
            'line1' => null,
            'line2' => null,
            'state' => null,
            'postalCode' => null
        ], $customerAddress);
        $address = array_filter($address);

        if (sizeof($address) > 0) {
            $details['address'] = $address;
        }

        $payload = [
            'customer_id' => $customerId,
            'personal_details' => $details
        ];
        $path = '/v0.1/customers';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('POST', $path, $payload, $headers);
    }

    /**
     * Update existing customer.
     *
     * @param $customerId
     * @param array $customerDetails
     * @param array $customerAddress
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function update($customerId, array $customerDetails = [], array $customerAddress = [])
    {
        if (empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }

        $details = array_merge([
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'phone' => null
        ], $customerDetails);
        $details = array_filter($details);

        $address = array_merge([
            'city' => null,
            'country' => null,
            'line1' => null,
            'line2' => null,
            'state' => null,
            'postalCode' => null
        ], $customerAddress);
        $address = array_filter($address);

        if (sizeof($address) > 0) {
            $details['address'] = $address;
        }
        $payload = [
            'customer_id' => $customerId,
            'personal_details' => $details
        ];
        $path = '/v0.1/customers/' . $customerId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('PUT', $path, $payload, $headers);
    }

    /**
     * Get customer by ID.
     *
     * @param $customerId
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function get($customerId)
    {
        if (empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        $path = '/v0.1/customers/' . $customerId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Get payment instruments for a customer.
     *
     * @param $customerId
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function getPaymentInstruments($customerId)
    {
        if (empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        $path = '/v0.1/customers/' . $customerId . '/payment-instruments';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Deactivate payment instrument for a customer.
     *
     * @param $customerId
     * @param $cardToken
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function deletePaymentInstruments($customerId, $cardToken)
    {
        if (empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        if (empty($cardToken)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('card token'));
        }
        $path = '/v0.1/customers/' . $customerId . '/payment-instruments/' . $cardToken;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('DELETE', $path, [], $headers);
    }
}
