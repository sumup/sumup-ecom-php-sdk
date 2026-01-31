<?php

namespace SumUp\Exceptions;

use Throwable;

/**
 * Class SumUpValidationException
 *
 * @package SumUp\Exceptions
 */
class SumUpValidationException extends SumUpSDKException
{
    const VALIDATION_ERROR_BASE = 'Validation error in: ';
    /**
     * Fields that are not valid.
     *
     * @var array
     */
    protected $fields;

    /**
     * SumUpValidationException constructor.
     *
     * @param array $fields
     * @param int   $code
     * @param Throwable|null  $previous
     */
    public function __construct(array $fields = [], int $code = 0, ?Throwable $previous = null)
    {
        $this->fields = $fields;
        $message = self::VALIDATION_ERROR_BASE . implode(', ', $fields);
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns the fields that failed the server validation.
     *
     * @return array
     */
    public function getInvalidFields(): array
    {
        return $this->fields;
    }
}
