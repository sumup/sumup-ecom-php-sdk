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
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phone
     * @param string $city
     * @param string $country
     * @param string $line1
     * @param string $line2
     * @param string $postalCode
     * @param string $state
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function create($customerId, $firstName = null, $lastName = null, $email = null, $phone = null, $city = null, $country = null, $line1 = null, $line2 = null, $postalCode = null, $state = null)
    {
        if(empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        $personalDetails = [];
        $address = [];

        if(isset($firstName)) {
            $personalDetails['first_name'] = $firstName;
        }
        if(isset($lastName)) {
            $personalDetails['last_name'] = $lastName;
        }
        if(isset($email)) {
            $personalDetails['email'] = $email;
        }
        if(isset($phone)) {
            $personalDetails['phone'] = $phone;
        }

        if(isset($city)) {
            $address['city'] = $city;
        }
        if(isset($country)) {
            $address['country'] = $country;
        }
        if(isset($line1)) {
            $address['line1'] = $line1;
        }
        if(isset($line2)) {
            $address['line2'] = $line2;
        }
        if(isset($postalCode)) {
            $address['postalCode'] = $postalCode;
        }
        if(isset($state)) {
            $address['state'] = $state;
        }
        if(count($address) > 0) {
            $personalDetails['address'] = $address;
        }
        $payload = [
            'customer_id' => $customerId,
            'personal_details' => $personalDetails
        ];
        $path = '/v0.1/customers';
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
        $headers += Headers::getTrk();
        return $this->client->send( 'POST', $path, $payload, $headers);
    }

    /**
     * Update existing customer.
     *
     * @param $customerId
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phone
     * @param string $city
     * @param string $country
     * @param string $line1
     * @param string $line2
     * @param string $postalCode
     * @param string $state
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     * @throws \SumUp\Exceptions\SumUpConnectionException
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    public function update($customerId, $firstName = null, $lastName = null, $email = null, $phone = null, $city = null, $country = null, $line1 = null, $line2 = null, $postalCode = null, $state = null)
    {
        if(empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        $personalDetails = [];
        $address = [];

        if(isset($firstName)) {
            $personalDetails['first_name'] = $firstName;
        }
        if(isset($lastName)) {
            $personalDetails['last_name'] = $lastName;
        }
        if(isset($email)) {
            $personalDetails['email'] = $email;
        }
        if(isset($phone)) {
            $personalDetails['phone'] = $phone;
        }

        if(isset($city)) {
            $address['city'] = $city;
        }
        if(isset($country)) {
            $address['country'] = $country;
        }
        if(isset($line1)) {
            $address['line1'] = $line1;
        }
        if(isset($line2)) {
            $address['line2'] = $line2;
        }
        if(isset($postalCode)) {
            $address['postalCode'] = $postalCode;
        }
        if(isset($state)) {
            $address['state'] = $state;
        }
        if(count($address) > 0) {
            $personalDetails['address'] = $address;
        }
        $payload = [
            'customer_id' => $customerId,
            'personal_details' => $personalDetails
        ];
        $path = '/v0.1/customers/' . $customerId;
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
        $headers += Headers::getTrk();
        return $this->client->send( 'PUT', $path, $payload, $headers);
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
        if(empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        $path = '/v0.1/customers/' . $customerId;
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
        $headers += Headers::getTrk();
        return $this->client->send('GET',  $path, [], $headers);
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
        if(empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        $path = '/v0.1/customers/' . $customerId . '/payment-instruments';
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
        $headers += Headers::getTrk();
        return $this->client->send('GET',  $path, [], $headers);
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
        if(empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        if(empty($cardToken)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('card token'));
        }
        $path = '/v0.1/customers/' . $customerId . '/payment-instruments/' . $cardToken;
        $headers = Headers::getCTJson();
        $headers += Headers::getAuth($this->accessToken);
        $headers += Headers::getTrk();
        return $this->client->send('DELETE',  $path, [], $headers);
    }
}