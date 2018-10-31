<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;

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
     * The version of the endpoint.
     *
     * @var string
     */
    protected $version = 'v0.1';

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
     * @param null $firstName
     * @param null $lastName
     * @param null $email
     * @param null $phone
     * @param null $city
     * @param null $country
     * @param null $line1
     * @param null $line2
     * @param null $postalCode
     * @param null $state
     * @return \SumUp\HttpClients\Response
     */
    public function create($customerId, $firstName = null, $lastName = null, $email = null, $phone = null, $city = null, $country = null, $line1 = null, $line2 = null, $postalCode = null, $state = null)
    {
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
        $path = '/' . $this->version . '/customers';
        return $this->client->send( 'POST', $path, $payload, $this->accessToken->getValue());
    }

    /**
     * Update existing customer.
     *
     * @param $customerId
     * @param null $firstName
     * @param null $lastName
     * @param null $email
     * @param null $phone
     * @param null $city
     * @param null $country
     * @param null $line1
     * @param null $line2
     * @param null $postalCode
     * @param null $state
     * @return \SumUp\HttpClients\Response
     */
    public function update($customerId, $firstName = null, $lastName = null, $email = null, $phone = null, $city = null, $country = null, $line1 = null, $line2 = null, $postalCode = null, $state = null)
    {
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
        $path = '/' . $this->version . '/customers/' . $customerId;
        return $this->client->send( 'PUT', $path, $payload, $this->accessToken->getValue());
    }

    /**
     * Get customer by ID.
     *
     * @param $customerId
     * @return \SumUp\HttpClients\Response
     */
    public function get($customerId)
    {
        $path = '/' . $this->version . '/customers/' . $customerId;
        return $this->client->send('GET',  $path, [], $this->accessToken->getValue());
    }

    /**
     * Create payment instruments for a customer.
     *
     * @param $customerId
     * @param $cardName
     * @param $cardNumber
     * @param $cardExpiryYear
     * @param $cardExpiryMonth
     * @param $cardCVV
     * @return \SumUp\HttpClients\Response
     */
    public function createPaymentInstruments($customerId, $cardName, $cardNumber, $cardExpiryYear, $cardExpiryMonth, $cardCVV)
    {
        $payload = [
            'type' => 'card',
            'card' => [
                'name' => $cardName,
                'number' => $cardNumber,
                'expiry_year' => $cardExpiryYear,
                'expiry_month' => $cardExpiryMonth,
                'cvv' => $cardCVV
            ]
        ];
        $path = '/' . $this->version . '/customers/' . $customerId . '/payment-instruments';
        return $this->client->send('POST', $path, $payload, $this->accessToken->getValue());
    }

    /**
     * Get payment instruments for a customer.
     *
     * @param $customerId
     * @return \SumUp\HttpClients\Response
     */
    public function getPaymentInstruments($customerId)
    {
        $path = '/' . $this->version . '/customers/' . $customerId . '/payment-instruments';
        return $this->client->send('GET',  $path, [], $this->accessToken->getValue());
    }

    /**
     * Deactivate payment instrument for a customer.
     *
     * @param $customerId
     * @param $cardToken
     * @return \SumUp\HttpClients\Response
     */
    public function deletePaymentInstruments($customerId, $cardToken)
    {
        $path = '/' . $this->version . '/customers/' . $customerId . '/payment-instruments/' . $cardToken;
        return $this->client->send('DELETE',  $path, [], $this->accessToken->getValue());
    }
}