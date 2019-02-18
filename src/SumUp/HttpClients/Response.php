<?php

namespace SumUp\HttpClients;

use SumUp\Exceptions\SumUpAuthenticationException;
use SumUp\Exceptions\SumUpResponseException;
use SumUp\Exceptions\SumUpServerException;
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
     * @var mixed
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
     * @throws SumUpServerException
     * @throws \SumUp\Exceptions\SumUpSDKException
     * @throws SumUpValidationException
     */
    public function __construct($httpResponseCode, $body)
    {
        $this->httpResponseCode = $httpResponseCode;
        $this->body = $body;
        $this->parseResponseForErrors();
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
     * Parses the response for containing errors.
     *
     * @return mixed
     *
     * @throws SumUpAuthenticationException
     * @throws SumUpResponseException
     * @throws SumUpValidationException
     * @throws SumUpServerException
     * @throws \SumUp\Exceptions\SumUpSDKException
     */
    protected function parseResponseForErrors()
    {
        if (isset($this->body->error_code) && $this->body->error_code === 'NOT_AUTHORIZED') {
            throw new SumUpAuthenticationException($this->body->error_message, $this->httpResponseCode);
        }
        if (isset($this->body->error_code) && ($this->body->error_code === 'MISSING' || $this->body->error_code === 'INVALID')) {
            throw new SumUpValidationException([$this->body->param], $this->httpResponseCode);
        }
        if (is_array($this->body) && sizeof($this->body) > 0 && isset($this->body[0]->error_code) && ($this->body[0]->error_code === 'MISSING' || $this->body[0]->error_code === 'INVALID')) {
            $invalidFields = [];
            foreach ($this->body as $errorObject) {
                $invalidFields[] = $errorObject->param;
            }
            throw new SumUpValidationException($invalidFields, $this->httpResponseCode);
        }
        if ($this->httpResponseCode >= 500) {
            $message = $this->parseErrorMessage('Server error');
            throw new SumUpServerException($message, $this->httpResponseCode);
        }
        if ($this->httpResponseCode >= 400) {
            $message = $this->parseErrorMessage('Client error');
            throw new SumUpResponseException($message, $this->httpResponseCode);
        }
    }

    /**
     * Return error message.
     * 
     * @param string $defaultMessage
     * 
     * @return string
     */
    protected function parseErrorMessage($defaultMessage = '')
    {
        if (is_null($this->body)) {
            return $defaultMessage;
        }

        if (isset($this->body->message)) {
            return $this->body->message;
        }

        if (isset($this->body->error_message)) {
            return $this->body->error_message;
        }

        return $defaultMessage;
    }
}
