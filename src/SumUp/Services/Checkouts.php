<?php

namespace SumUp\Services;

use SumUp\Exceptions\SumUpArgumentException;
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
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    /**
     * Create new checkout.
     *
     * @param $amount
     * @param string $currency
     * @param string $checkoutRef
     * @param string $payToEmail
     * @param string $description
     * @param null $payFromEmail
     * @param null $returnURL
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function create($amount, $currency, $checkoutRef, $payToEmail, $description = '', $payFromEmail = null, $returnURL = null)
    {
        if(empty($amount) || !is_numeric($amount)) {
            throw new SumUpArgumentException('Argument is missing. Amount is not provided.');
        }
        if(empty($currency)) {
            throw new SumUpArgumentException('Argument is missing. Currency is not provided.');
        }
        if(empty($checkoutRef)) {
            throw new SumUpArgumentException('Argument is missing. Checkout reference id is not provided.');
        }
        if(empty($payToEmail)) {
            throw new SumUpArgumentException('Argument is missing. Pay to email is not provided.');
        }
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
     * @param string $checkoutId
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function findById($checkoutId)
    {
        if(empty($checkoutId)) {
            throw new SumUpArgumentException('Argument is missing. Checkout id is not provided.');
        }
        $path = '/v0.1/checkouts/' . $checkoutId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Get single checkout by provided checkout reference ID.
     *
     * @param string $referenceId
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function findByReferenceId($referenceId)
    {
        if(empty($referenceId)) {
            throw new SumUpArgumentException('Argument is missing. Reference id is not provided.');
        }
        $path = '/v0.1/checkouts?checkout_reference=' . $referenceId;
        return $this->client->send('GET', $path, [], $this->accessToken->getValue());
    }

    /**
     * Delete a checkout.
     *
     * @param string $checkoutId
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function delete($checkoutId)
    {
        if(empty($checkoutId)) {
            throw new SumUpArgumentException('Argument is missing. Checkout id is not provided.');
        }
        $path = '/v0.1/checkouts/' . $checkoutId;
        return $this->client->send('DELETE', $path, [], $this->accessToken->getValue());
    }

    /**
     * Pay a checkout with tokenized card.
     *
     * @param string $checkoutId
     * @param string $customerId
     * @param string $cardToken
     * @param int $installments
     *
     * @return \SumUp\HttpClients\Response
     *
     * @throws SumUpArgumentException
     */
    public function pay($checkoutId, $customerId, $cardToken, $installments = 1)
    {
        if(empty($checkoutId)) {
            throw new SumUpArgumentException('Argument is missing. Checkout id is not provided.');
        }
        if(empty($customerId)) {
            throw new SumUpArgumentException('Argument is missing. Customer id is not provided.');
        }
        if(empty($cardToken)) {
            throw new SumUpArgumentException('Argument is missing. Card token is not provided.');
        }
        if(empty($installments) || !is_int($installments)) {
            throw new SumUpArgumentException('Argument is missing. Installments are not provided.');
        }
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
