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
        $path = '/v0.1/checkouts';
        return $this->client->send( 'POST', $path, $payload, $this->accessToken->getValue());
    }

    /**
     * Get single checkout by provided checkout ID.
     *
     * @param $checkoutId
     * @return \SumUp\HttpClients\Response
     */
    public function findById($checkoutId)
    {
        // TODO: throw an error if the param is not passed or is null
        $path = '/v0.1/checkouts/' . $checkoutId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get single checkout by provided checkout reference ID.
     *
     * @param $referenceId
     * @return \SumUp\HttpClients\Response
     */
    public function findByReferenceId($referenceId)
    {
        // TODO: throw an error if the param is not passed or is null
        $path = '/v0.1/checkouts?checkout_reference=' . $referenceId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Delete a checkout.
     *
     * @param $checkoutId
     * @return \SumUp\HttpClients\Response
     */
    public function delete($checkoutId)
    {
        // TODO: throw an error if the param is not passed or is null
        $path = '/v0.1/checkouts/' . $checkoutId;
        return $this->client->send('DELETE', $path, [], $this->accessToken->getValue());
    }

    /**
     * Pay a checkout with tokenized card.
     *
     * @param $checkoutId
     * @param $customerId
     * @param $cardToken
     * @param int $installments
     * @return \SumUp\HttpClients\Response
     */
    public function pay($checkoutId, $customerId, $cardToken, $installments = 1)
    {
        // TODO: throw an error if the param is not passed or is null
        $payload = [
            'payment_type' => 'card',
            'customer_id' => $customerId,
            'token' => $cardToken,
            'installments' => $installments
        ];
        $path = '/v0.1/checkouts/' . $checkoutId;
        return $this->client->send('PUT', $path, $payload, $this->accessToken->getValue());
    }
}
