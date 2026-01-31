<?php

namespace SumUp\HttpClients;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use SumUp\Exceptions\SumUpAuthenticationException;
use SumUp\Exceptions\SumUpConnectionException;
use SumUp\Exceptions\SumUpResponseException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\Exceptions\SumUpServerException;
use SumUp\Exceptions\SumUpValidationException;

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
     * @var Client $guzzleClient
     */
    private $guzzleClient;

    /**
     * Custom headers for every request.
     *
     * @var array $customHeaders
     */
    private $customHeaders;

    /**
     * SumUpGuzzleHttpClient constructor.
     *
     * @param string      $baseUrl
     * @param array       $customHeaders
     * @param string|bool|null $caBundlePath
     */
    public function __construct(string $baseUrl, array $customHeaders, $caBundlePath = null)
    {
        $options = ['base_uri' => $baseUrl];
        if ($caBundlePath !== null) {
            $options['verify'] = $caBundlePath;
        }

        $this->guzzleClient = new Client($options);
        $this->customHeaders = $customHeaders;
    }

    /**
     * @param string $method      The request method.
     * @param string $url         The endpoint to send the request to.
     * @param array  $body        The body of the request.
     * @param array  $headers     The headers of the request.
     *
     * @return Response
     *
     * @throws SumUpConnectionException
     * @throws SumUpServerException
     * @throws SumUpResponseException
     * @throws SumUpAuthenticationException
     * @throws SumUpValidationException
     * @throws SumUpSDKException
     */
    public function send(string $method, string $url, array $body, array $headers = []): Response
    {
        $options = [
            'headers' => array_merge($headers, $this->customHeaders),
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
            $message = $body->message ?? $body;
            throw new SumUpServerException($message, $e->getCode(), $e->getPrevious());
        } catch (GuzzleException|Exception $e) {
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
