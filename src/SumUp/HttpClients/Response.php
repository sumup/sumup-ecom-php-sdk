<?php

namespace SumUp\HttpClients;

use SumUp\Exceptions\SumUpAuthenticationException;
use SumUp\Exceptions\SumUpResponseException;
use SumUp\Exceptions\SumUpValidationException;

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
     * @var number
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
     * @param number $httpResponseCode
     * @param $body
     *
     * @throws SumUpAuthenticationException
     * @throws SumUpResponseException
     * @throws SumUpValidationException
     */
    public function __construct($httpResponseCode, $body)
    {
        $this->httpResponseCode = $httpResponseCode;
        $this->body = $this->parseBody($body);
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

    /**
     * Parses the body for containing errors.
     *
     * @param $body
     *
     * @return mixed
     *
     * @throws SumUpAuthenticationException
     * @throws SumUpResponseException
     * @throws SumUpValidationException
     */
    protected function parseBody($body)
    {
        if(isset($body->error_code) && $body->error_code === 'NOT_AUTHORIZED') {
            throw new SumUpAuthenticationException($body->error_message, $this->httpResponseCode);
        }
        if(isset($body->error_code) && $body->error_code === 'MISSING') {
            throw new SumUpValidationException([$body->param], $this->httpResponseCode);
        }
        if(is_array($body) && isset($body[0]->error_code) && $body[0]->error_code === 'MISSING') {
            $invalidFields = [];
            foreach ($body as $errorObject) {
                $invalidFields[] = $errorObject->param;
            }
            throw new SumUpValidationException($invalidFields, $this->httpResponseCode);
        }
        if($this->httpResponseCode >= 400) {
            if (isset($body) && isset($body->message)) {
                $message = $body->message;
            } else {
                $message = $body;
            }
            throw new SumUpResponseException($message, $this->httpResponseCode);
        }

        return $body;
    }
}