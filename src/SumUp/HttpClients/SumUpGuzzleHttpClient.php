<?php

namespace SumUp\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class SumUpGuzzleHttpClient implements SumUpHttpClientInterface
{

    protected $guzzleClient;

    public function __construct($baseUrl)
    {
        $this->guzzleClient = new Client(['base_uri' => $baseUrl]);
    }

    /**
     * @inheritdoc
     */
    public function send($method, $url, $body, $accessToken = null)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];
        if ($accessToken) {
            $headers['Authorization'] = 'Bearer ' . $accessToken;
        }

        $options = [
            'headers' => $headers,
//            'debug' => true,
            'json' => $body
        ];

        $request = new Request($method, $url);

        try {
            $response = $this->guzzleClient->send($request, $options);
        } catch (\Exception $e) {
            $response = $e->getResponse();

//            echo($response->getBody());
            // TODO: throw custom exception
            throw new \Exception($response->getReasonPhrase(), $response->getStatusCode());
        }

        $body = json_decode($response->getBody());

        return new Response($response->getStatusCode(), $body);
    }
}
