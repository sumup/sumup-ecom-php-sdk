<?php

namespace SumUp\Utils;

use SumUp\Authentication\AccessToken;
use SumUp\SdkInfo;

/**
 * Class Headers
 *
 * @package SumUp\Utils
 */
class Headers
{
    /**
     * Get the common header for Content-Type: application/json.
     *
     * @return array
     */
    public static function getCTJson()
    {
        return ['Content-Type' => 'application/json'];
    }

    /**
     * Get the common header for Content-Type: application/x-www-form-urlencoded.
     *
     * @return array
     */
    public static function getCTForm()
    {
        return ['Content-Type' => 'application/x-www-form-urlencoded'];
    }

    /**
     * Get the authorization header with token.
     *
     * @param AccessToken $accessToken
     *
     * @return array
     */
    public static function getAuth(AccessToken $accessToken)
    {
        return ['Authorization' => 'Bearer ' . $accessToken->getValue()];
    }

    /**
     * Get standard headers needed for every request.
     *
     * @return array
     */
    public static function getStandardHeaders()
    {
        $headers = self::getCTJson();
        $headers['User-Agent'] = SdkInfo::getUserAgent();
        return $headers;
    }
}
