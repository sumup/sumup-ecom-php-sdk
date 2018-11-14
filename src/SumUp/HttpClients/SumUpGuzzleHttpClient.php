<?php

namespace SumUp\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use SumUp\Exceptions\SumUpConnectionException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\Exceptions\SumUpServerException;

/**
 * Class SumUpGuzzleHttpClient
 *
 * @package SumUp\HttpClients
 */
class SumUpGuzzleHttpClient implements SumUpHttpClientInterface
{
    /**
     * The Guzzle Client instance.
     *
     * @var Client
     */
    protected $guzzleClient;

    /**
     * SumUpGuzzleHttpClient constructor.
     *
     * @param $baseUrl
     */
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
        } catch (ConnectException $e) {
            throw new SumUpConnectionException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody());
            return new Response($response->getStatusCode(), $body);
        } catch (ServerException $e) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody());
            throw new SumUpServerException($body->err_code, $e->getCode(), $e->getPrevious());
        } catch (\Exception $e) {
            throw new SumUpSDKException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        $body = json_decode($response->getBody());
        return new Response($response->getStatusCode(), $body);
    }
}
