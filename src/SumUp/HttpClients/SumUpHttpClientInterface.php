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
     * @param string $body        The body of the request.
     * @param string $accessToken The value of the access token.
     *
     * @return Response|mixed
     */
    public function send($method, $url, $body, $accessToken);
}
