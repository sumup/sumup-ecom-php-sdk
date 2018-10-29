<?php

namespace SumUp\HttpClients;

/**
 * Class Response
 *
 * @package SumUp\HttpClients
 */
class Response
{
    /**
     * The HTTP response code.
     *
     * @var number;
     */
    protected $httpResponseCode;

    /**
     * The response body.
     *
     * @var array
     */
    protected $body;

    /**
     * Response constructor.
     *
     * @param $httpResponseCode
     * @param $body
     */
    public function __construct($httpResponseCode, $body)
    {
        $this->httpResponseCode = $httpResponseCode;
        $this->body = $body;
    }

    /**
     * Get HTTP response code.
     *
     * @return number
     */
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

    /**
     * Get the response body.
     *
     * @return array|mixed
     */
    public function getBody()
    {
        return $this->body;
    }
}