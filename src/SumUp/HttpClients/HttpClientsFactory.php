<?php

namespace SumUp\HttpClients;

use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\Application\ApplicationConfigurationInterface;

/**
 * Class HttpClientsFactory
 *
 * @package SumUp\HttpClients
 */
class HttpClientsFactory
{
    private function __construct()
    {
        // a factory constructor should never be invoked
    }

    /**
     * Create the HTTP client needed for communication with the SumUp's servers.
     *
     * @param ApplicationConfigurationInterface $appConfig
     * @param SumUpHttpClientInterface|null $customHttpClient
     *
     * @return SumUpHttpClientInterface
     *
     * @throws SumUpConfigurationException
     */
    public static function createHttpClient(ApplicationConfigurationInterface $appConfig, SumUpHttpClientInterface $customHttpClient = null)
    {
        if ($customHttpClient) {
            return $customHttpClient;
        }
        return self::detectDefaultClient($appConfig->getBaseURL(), $appConfig->getForceGuzzle(), $appConfig->getCustomHeaders());
    }

    /**
     * Detect the default HTTP client.
     *
     * @param string $baseURL
     * @param bool $forceUseGuzzle
     *
     * @return SumUpCUrlClient|SumUpGuzzleHttpClient
     *
     * @throws SumUpConfigurationException
     */
    private static function detectDefaultClient($baseURL, $forceUseGuzzle, $customHeaders)
    {
        if (extension_loaded('curl') && !$forceUseGuzzle) {
            return new SumUpCUrlClient($baseURL, $customHeaders);
        }
        if (class_exists('GuzzleHttp\Client')) {
            return new SumUpGuzzleHttpClient($baseURL, $customHeaders);
        }

        throw new SumUpConfigurationException('No default http client found. Please install cURL or GuzzleHttp.');
    }
}
