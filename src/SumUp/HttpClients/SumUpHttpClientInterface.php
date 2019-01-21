<?php

namespace SumUp\HttpClients;

/**
 * Interface SumUpHttpClientInterface
 *
 * @package SumUp\HttpClients
 */
interface SumUpHttpClientInterface
{
    /**
     * @param string $method      The request method.
     * @param string $url         The endpoint to send the request to.
     * @param array  $body        The body of the request.
     * @param array  $headers     The headers of the request.
     *
     * @return Response|mixed
     */
    public function send($method, $url, $body, $headers);
}
