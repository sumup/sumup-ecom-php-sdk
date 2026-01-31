<?php

namespace SumUp\Utils;

/**
 * Class ExceptionMessages
 *
 * @package SumUp\Utils
 */
class ExceptionMessages
{
    /**
     * Get formatted message for missing parameter.
     *
     * @param string $missingParamName
     *
     * @return string
     */
    public static function getMissingParamMsg(string $missingParamName): string
    {
        return 'Missing parameter: "' . $missingParamName . '".';
    }
}
