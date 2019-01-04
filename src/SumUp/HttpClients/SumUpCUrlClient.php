<?php

namespace SumUp\HttpClients;

use SumUp\Exceptions\SumUpConnectionException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\HttpClients\SumUpHttpClientInterface;

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
     * SumUpCUrlClient constructor.
     *
     * @param $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @inheritdoc
     */
    public function send($method, $url, $body, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($headers));
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