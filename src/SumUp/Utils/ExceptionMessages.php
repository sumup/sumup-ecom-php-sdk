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
     * @param $missingParamName
     *
     * @return string
     */
    public static function getMissingParamMsg($missingParamName)
    {
        return 'Missing parameter: "' . $missingParamName . '".';
    }
}
