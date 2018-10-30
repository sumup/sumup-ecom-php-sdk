<?php

namespace SumUp\Services;

use SumUp\HttpClients\SumUpHttpClientInterface;
use SumUp\Authentication\AccessToken;

class Checkouts implements SumUpService
{
    protected $client;

    protected $accessToken;

    protected $version = 'v0.1';

    public function __construct(SumUpHttpClientInterface $client, AccessToken $accessToken)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

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
            echo '<b>Add pay from email</b>';
            $payload['pay_from_email'] = $payFromEmail;
        }
        if(isset($returnURL)) {
            $payload['return_url'] = $returnURL;
        }
        return $this->client->send( 'POST', '/' .$this->version . '/checkouts', $payload, $this->accessToken->getValue());
    }

    public function get($checkoutId = null)
    {
        if(isset($checkoutId)) {
            return $this->client->send('GET', '/' . $this->version . '/checkouts/' . $checkoutId, [], $this->accessToken->getValue());
        } else {
            return $this->client->send('GET', '/' . $this->version . '/checkouts', [], $this->accessToken->getValue());
        }
    }

    public function delete($checkoutId)
    {
        return $this->client->send('DELETE', '/' . $this->version . '/checkouts/' . $checkoutId, [], $this->accessToken->getValue());
    }
}
