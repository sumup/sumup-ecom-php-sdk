<?php

namespace SumUp\HttpClients;

use SumUp\Exceptions\SumUpAuthenticationException;
use SumUp\Exceptions\SumUpConnectionException;
use SumUp\Exceptions\SumUpResponseException;
use SumUp\Exceptions\SumUpSDKException;
use SumUp\Exceptions\SumUpValidationException;

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
     * The CA bundle path used to verify HTTPS calls.
     *
     * @var string|null
     */
    private $caBundlePath;

    /**
     * SumUpCUrlClient constructor.
     *
     * @param string      $baseUrl
     * @param array       $customHeaders
     * @param string|null $caBundlePath
     */
    public function __construct(string $baseUrl, array $customHeaders, ?string $caBundlePath = null)
    {
        $this->baseUrl = $baseUrl;
        $this->customHeaders = $customHeaders;
        $this->caBundlePath = $caBundlePath;
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
     * @throws SumUpResponseException
     * @throws SumUpAuthenticationException
     * @throws SumUpValidationException
     * @throws SumUpSDKException
     */
    public function send(string $method, string $url, array $body, array $headers = []): Response
    {
        $reqHeaders = array_merge($headers, $this->customHeaders);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($reqHeaders));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($body)) {
            $payload = json_encode($body);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }

        if (!empty($this->caBundlePath)) {
            curl_setopt($ch, CURLOPT_CAINFO, $this->caBundlePath);
        }

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $error = curl_error($ch);
        if ($error) {
            curl_close($ch);
            throw new SumUpConnectionException($error, $code);
        }

        curl_close($ch);
        return new Response($code, $this->parseBody($response));
    }

    /**
     * Format the headers to be compatible with cURL.
     *
     * @param array|null $headers
     *
     * @return array
     */
    private function formatHeaders(?array $headers = null): array
    {
        if (count($headers) == 0) {
            return $headers;
        }

        $keys = array_keys($headers);
        $formattedHeaders = [];
        foreach ($keys as $key) {
            $formattedHeaders[] = $key . ': ' . $headers[$key];
        }
        return $formattedHeaders;
    }

    /**
     * Returns JSON encoded the response's body if it is of JSON type.
     *
     * @param bool|string $response
     *
     * @return bool|string
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
