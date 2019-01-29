<?php

namespace SumUp\HttpClients;

use SumUp\Exceptions\SumUpConnectionException;
use SumUp\Exceptions\SumUpSDKException;

/**
 * Class SumUpCUrlClient
 *
 * @package SumUp\HttpClients
 */
class SumUpCUrlClient implements SumUpHttpClientInterface
{
    /**
     * The base URL.
     *
     * @var $baseUrl
     */
    private $baseUrl;

    /**
     * Custom headers for every request.
     *
     * @var $customHeaders
     */
    private $customHeaders;

    /**
     * SumUpCUrlClient constructor.
     *
     * @param string $baseUrl
     * @param array  $customHeaders
     */
    public function __construct($baseUrl, $customHeaders)
    {
        $this->baseUrl = $baseUrl;
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
     * @throws \SumUp\Exceptions\SumUpResponseException
     * @throws \SumUp\Exceptions\SumUpAuthenticationException
     * @throws \SumUp\Exceptions\SumUpValidationException
     * @throws SumUpSDKException
     */
    public function send($method, $url, $body, $headers = [])
    {
        $reqHeaders = array_merge($headers, $this->customHeaders);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($reqHeaders));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        if (!empty($body)) {
            $payload = json_encode($body);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $error = curl_error($ch);
        if ($error) {
            curl_close ($ch);
            throw new SumUpConnectionException($error, $code);
        }

        curl_close ($ch);
        return new Response($code, $this->parseBody($response));
    }

    /**
     * Format the headers to be compatible with cURL.
     *
     * @param array|null $headers
     *
     * @return array
     */
    private function formatHeaders($headers = null)
    {
        if (count($headers) == 0) {
            return $headers;
        }

        $keys = array_keys($headers);
        $formattedHeaders = [];
        foreach($keys as $key) {
            $formattedHeaders[] = $key . ': ' . $headers[$key];
        }
        return $formattedHeaders;
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
        $jsonBody = json_decode($response);
        if (isset($jsonBody)) {
            return $jsonBody;
        }
        return $response;
    }
}