<?php

namespace SumUp\Utils;

use SumUp\Authentication\AccessToken;

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
     * Get custom array.
     *
     * @return array
     */
    public static function getTrk()
    {
        $pathToComposer = realpath(dirname(__FILE__) . '/../../../composer.json');
        $content = file_get_contents($pathToComposer);
        $content = json_decode($content, true);
        return ['X-SDK' => 'PHP/v' . $content['version']];
    }
}
