<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;

/**
 * Class Checkouts
 *
 * @package SumUp\Services
 */
class Checkouts implements SumUpService
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
     * Create new checkout.
     *
     * @param $amount
     * @param $currency
     * @param $checkoutRef
     * @param $payToEmail
     * @param string $description
     * @param null $payFromEmail
     * @param null $returnURL
     * @return \SumUp\HttpClients\Response
     */
    public function create($amount, $currency, $checkoutRef, $payToEmail, $description = '', $payFromEmail = null, $returnURL = null)
    {
        $payload = [
            'amount' => $amount,
            'currency' => $currency,
            'checkout_reference' => $checkoutRef,
            'pay_to_email' => $payToEmail,
            'description' => $description
        ];
        if(isset($payFromEmail)) {
            $payload['pay_from_email'] = $payFromEmail;
        }
        if(isset($returnURL)) {
            $payload['return_url'] = $returnURL;
        }
        return $this->client->send( 'POST', '/' .$this->version . '/checkouts', $payload, $this->accessToken->getValue());
    }

    /**
     * Get all checkouts. If you pass a checkout ID you'll get the data for it.
     *
     * @param null $checkoutId
     * @return \SumUp\HttpClients\Response
     */
    public function get($checkoutId = null)
    {
        if(isset($checkoutId)) {
            return $this->client->send('GET', '/' . $this->version . '/checkouts/' . $checkoutId, [], $this->accessToken->getValue());
        } else {
            return $this->client->send('GET', '/' . $this->version . '/checkouts', [], $this->accessToken->getValue());
        }
    }

    /**
     * Delete a checkout.
     *
     * @param $checkoutId
     * @return \SumUp\HttpClients\Response
     */
    public function delete($checkoutId)
    {
        return $this->client->send('DELETE', '/' . $this->version . '/checkouts/' . $checkoutId, [], $this->accessToken->getValue());
    }
}
