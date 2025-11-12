<?php

namespace SumUp;

/**
 * Provides metadata about the SDK.
 */
class SdkInfo
{
    const USER_AGENT_TEMPLATE = 'sumup-php/v%s';

    /**
     * Returns the SDK version embedded in the build.
     *
     * @return string
     */
    public static function getVersion()
    {
        return Version::CURRENT;
    }

    /**
     * Returns the formatted User-Agent string used in outbound requests.
     *
     * @return string
     */
    public static function getUserAgent()
    {
        return sprintf(self::USER_AGENT_TEMPLATE, self::getVersion());
    }
}
