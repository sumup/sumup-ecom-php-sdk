<?php

declare(strict_types=1);

namespace SumUp\Shared;

/**
 * Profile's personal address information.
 */
class AddressLegacy
{
    /**
     * City name from the address.
     *
     * @var string|null
     */
    public ?string $city = null;

    /**
     * Two letter country code formatted according to [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2).
     *
     * @var string|null
     */
    public ?string $country = null;

    /**
     * First line of the address with details of the street name and number.
     *
     * @var string|null
     */
    public ?string $line1 = null;

    /**
     * Second line of the address with details of the building, unit, apartment, and floor numbers.
     *
     * @var string|null
     */
    public ?string $line2 = null;

    /**
     * Postal code from the address.
     *
     * @var string|null
     */
    public ?string $postalCode = null;

    /**
     * State name or abbreviation from the address.
     *
     * @var string|null
     */
    public ?string $state = null;

}

/**
 * Amount of the event.
 */
class AmountEvent
{
}

/**
 * Object attributes that are modifiable only by SumUp applications.
 */
class Attributes
{
}

/**
 * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
 */
class Currency
{
}

/**
 * Error message structure.
 */
class Error
{
    /**
     * Short description of the error.
     *
     * @var string|null
     */
    public ?string $message = null;

    /**
     * Platform code for the error.
     *
     * @var string|null
     */
    public ?string $errorCode = null;

}

/**
 * Error message for forbidden requests.
 */
class ErrorForbidden
{
    /**
     * Short description of the error.
     *
     * @var string|null
     */
    public ?string $errorMessage = null;

    /**
     * Platform code for the error.
     *
     * @var string|null
     */
    public ?string $errorCode = null;

    /**
     * HTTP status code for the error.
     *
     * @var string|null
     */
    public ?string $statusCode = null;

}

/**
 * Unique ID of the transaction event.
 */
class EventId
{
}

/**
 * Status of the transaction event.
 */
class EventStatus
{
}

/**
 * Type of the transaction event.
 */
class EventType
{
}

/**
 * Pending invitation for membership.
 */
class Invite
{
    /**
     * Email address of the invited user.
     *
     * @var string
     */
    public string $email;

    /**
     *
     * @var string
     */
    public string $expiresAt;

}

/**
 * Created mandate
 */
class MandateResponse
{
    /**
     * Indicates the mandate type
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * Mandate status
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Merchant code which has the mandate
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

}

/**
 * The status of the membership.
 */
class MembershipStatus
{
}

/**
 * A set of key-value pairs that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 *
 * **Warning**: Updating Meta will overwrite the existing data. Make sure to always include the complete JSON object.
 */
class Meta
{
}

/**
 * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata.
 */
class Metadata
{
}

/**
 * Personal details for the customer.
 */
class PersonalDetails
{
    /**
     * First name of the customer.
     *
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * Last name of the customer.
     *
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * Email address of the customer.
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     * Phone number of the customer.
     *
     * @var string|null
     */
    public ?string $phone = null;

    /**
     * Date of birth of the customer.
     *
     * @var string|null
     */
    public ?string $birthDate = null;

    /**
     * An identification number user for tax purposes (e.g. CPF)
     *
     * @var string|null
     */
    public ?string $taxId = null;

    /**
     * Profile's personal address information.
     *
     * @var AddressLegacy|null
     */
    public ?AddressLegacy $address = null;

}

/**
 * Date and time of the transaction event.
 */
class TimestampEvent
{
}

/**
 * Details of the transaction.
 */
class TransactionBase
{
    /**
     * Unique ID of the transaction.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Transaction code returned by the acquirer/processing entity after processing the transaction.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Total amount of the transaction.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var Currency|null
     */
    public ?Currency $currency = null;

    /**
     * Date and time of the creation of the transaction. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Current status of the transaction.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Payment type used for the transaction.
     *
     * @var string|null
     */
    public ?string $paymentType = null;

    /**
     * Current number of the installment for deferred payments.
     *
     * @var int|null
     */
    public ?int $installmentsCount = null;

}

class TransactionCheckoutInfo
{
    /**
     * Unique code of the registered merchant to whom the payment is made.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Amount of the applicable VAT (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Amount of the tip (out of the total transaction amount).
     *
     * @var float|null
     */
    public ?float $tipAmount = null;

    /**
     * Entry mode of the payment details.
     *
     * @var string|null
     */
    public ?string $entryMode = null;

    /**
     * Authorization code for the transaction sent by the payment card issuer or bank. Applicable only to card payments.
     *
     * @var string|null
     */
    public ?string $authCode = null;

    /**
     * Internal unique ID of the transaction on the SumUp platform.
     *
     * @var int|null
     */
    public ?int $internalId = null;

}

/**
 * Unique ID of the transaction.
 */
class TransactionId
{
}
