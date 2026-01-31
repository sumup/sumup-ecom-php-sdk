<?php

namespace SumUp\Services;

use SumUp\Exceptions\SumUpArgumentException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\HttpClients\Response;
use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;
use SumUp\Utils\ExceptionMessages;
use SumUp\Utils\Headers;

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
     * @param float  $amount
     * @param string $currency
     * @param string $checkoutRef
     * @param string $merchantCode
     * @param string $description
     * @param null|string   $payFromEmail
     * @param null|string   $returnURL
     * @param null|string   $redirectURL
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function create(
        float $amount,
        string $currency,
        string $checkoutRef,
        string $merchantCode,
        string $description = '',
        ?string $payFromEmail = null,
        ?string $returnURL = null,
        ?string $redirectURL = null
    ): Response {
        if (empty($amount) || !is_numeric($amount)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('amount'));
        }
        if (empty($currency)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('currency'));
        }
        if (empty($checkoutRef)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('checkout reference id'));
        }
        if (empty($merchantCode)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('merchant code'));
        }

        $payload = [
            'merchant_code' => $merchantCode,
            'amount' => $amount,
            'currency' => $currency,
            'checkout_reference' => $checkoutRef,
            'description' => $description
        ];

        if (isset($payFromEmail)) {
            $payload['pay_from_email'] = $payFromEmail;
        }
        if (isset($returnURL)) {
            $payload['return_url'] = $returnURL;
        }
        if (isset($redirectURL)) {
            $payload['redirect_url'] = $redirectURL;
        }
        $path = '/v0.1/checkouts';
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('POST', $path, $payload, $headers);
    }

    /**
     * Get single checkout by provided checkout ID.
     *
     * @param string $checkoutId
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function findById(string $checkoutId): Response
    {
        if (empty($checkoutId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('checkout id'));
        }
        $path = '/v0.1/checkouts/' . $checkoutId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Get single checkout by provided checkout reference ID.
     *
     * @param string $referenceId
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function findByReferenceId(string $referenceId): Response
    {
        if (empty($referenceId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('reference id'));
        }
        $path = '/v0.1/checkouts?checkout_reference=' . $referenceId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('GET', $path, [], $headers);
    }

    /**
     * Delete a checkout.
     *
     * @param string $checkoutId
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function delete(string $checkoutId): Response
    {
        if (empty($checkoutId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('checkout id'));
        }
        $path = '/v0.1/checkouts/' . $checkoutId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('DELETE', $path, [], $headers);
    }

    /**
     * Pay a checkout with tokenized card.
     *
     * @param string $checkoutId
     * @param string $customerId
     * @param string $cardToken
     * @param int    $installments
     *
     * @return Response
     *
     * @throws SumUpArgumentException
     * @throws SumUpSDKException
     */
    public function pay(string $checkoutId, string $customerId, string $cardToken, int $installments = 1): Response
    {
        if (empty($checkoutId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('checkout id'));
        }
        if (empty($customerId)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('customer id'));
        }
        if (empty($cardToken)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('card token'));
        }
        if (empty($installments) || !is_int($installments)) {
            throw new SumUpArgumentException(ExceptionMessages::getMissingParamMsg('installments'));
        }
        $payload = [
            'payment_type' => 'card',
            'customer_id' => $customerId,
            'token' => $cardToken,
            'installments' => $installments
        ];
        $path = '/v0.1/checkouts/' . $checkoutId;
        $headers = array_merge(Headers::getStandardHeaders(), Headers::getAuth($this->accessToken));
        return $this->client->send('PUT', $path, $payload, $headers);
    }
}
