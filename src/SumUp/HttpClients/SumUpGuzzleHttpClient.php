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
     * @var client
     */
    private $guzzleClient;

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
    public function send($method, $url, $body, $headers = [])
    {
        $options = [
            'headers' => $headers,
            'json' => $body
        ];

        $request = new Request($method, $url);

        try {
            $response = $this->guzzleClient->send($request, $options);
        } catch (ConnectException $e) {
            throw new SumUpConnectionException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $this->parseBody($response);
            return new Response($response->getStatusCode(), $body);
        } catch (ServerException $e) {
            $response = $e->getResponse();
            $body = $this->parseBody($response);
            throw new SumUpServerException($body->error_code, $e->getCode(), $e->getPrevious());
        } catch (\Exception $e) {
            throw new SumUpSDKException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
        $body = $this->parseBody($response);
        return new Response($response->getStatusCode(), $body);
    }

    /**
     * Returns JSON encoded the response's body if it is of JSON type.
     *
     * @param $response
     *
     * @return mixed
     */
    private function parseBody($response)
    {
        $jsonBody = json_decode($response->getBody());
        if (isset($jsonBody)) {
            return $jsonBody;
        }
        return $response->getBody();
    }
}
