<?php

namespace SumUp\Utils;

/**
 * Class ExceptionMessages
 *
 * @package SumUp\Utils
 */
class ExceptionMessages
{
    public static function getMissingParamMsg($wrongParamName)
    {
        return 'Missing parameter: "' . $wrongParamName . '".';
    }
}
