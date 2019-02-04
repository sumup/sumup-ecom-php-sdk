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
     * Cached value of the project's version.
     *
     * @var string $cacheVersion
     */
    protected static $cacheVersion;
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
        return ['X-SDK' => 'PHP-SDK/v' . self::getProjectVersion() . ' PHP/v' . phpversion()];
    }

    /**
     * Get the version of the project accroding to the composer.json
     *
     * @return string
     */
    public static function getProjectVersion()
    {
        if (is_null(self::$cacheVersion)) {
            $pathToComposer = realpath(dirname(__FILE__) . '/../../../composer.json');
            $content = file_get_contents($pathToComposer);
            $content = json_decode($content, true);
            self::$cacheVersion = $content['version'];
        }

        return self::$cacheVersion;
    }

    /**
     * Get standard headers needed for every request.
     *
     * @return array
     */
    public static function getStandardHeaders()
    {
        $headers = self::getCTJson();
        $headers += self::getTrk();
        return $headers;
    }
}
