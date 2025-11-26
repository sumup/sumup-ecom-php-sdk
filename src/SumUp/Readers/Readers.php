<?php

declare(strict_types=1);

namespace SumUp\Readers;

/**
 * Error description
 */
class CreateReaderCheckoutError
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * Reader Checkout
 */
class CreateReaderCheckoutRequest
{
    /**
     * Affiliate metadata for the transaction.
     * It is a field that allow for integrators to track the source of the transaction.
     *
     * @var array|null
     */
    public ?array $affiliate = null;

    /**
     * The card type of the card used for the transaction.
     * Is is required only for some countries (e.g: Brazil).
     *
     * @var string|null
     */
    public ?string $cardType = null;

    /**
     * Description of the checkout to be shown in the Merchant Sales
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Number of installments for the transaction.
     * It may vary according to the merchant country.
     * For example, in Brazil, the maximum number of installments is 12.
     *
     * @var int|null
     */
    public ?int $installments = null;

    /**
     * Webhook URL to which the payment result will be sent.
     * It must be a HTTPS url.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * List of tipping rates to be displayed to the cardholder.
     * The rates are in percentage and should be between 0.01 and 0.99.
     * The list should be sorted in ascending order.
     *
     * @var float[]|null
     */
    public ?array $tipRates = null;

    /**
     * Time in seconds the cardholder has to select a tip rate.
     * If not provided, the default value is 30 seconds.
     * It can only be set if `tip_rates` is provided.
     * **Note**: If the target device is a Solo, it must be in version 3.3.38.0 or higher.
     *
     * @var int|null
     */
    public ?int $tipTimeout = null;

    /**
     * Amount structure.
     * The amount is represented as an integer value altogether with the currency and the minor unit.
     * For example, EUR 1.00 is represented as value 100 with minor unit of 2.
     *
     * @var array
     */
    public array $totalAmount;

}

class CreateReaderCheckoutResponse
{
    /**
     *
     * @var array
     */
    public array $data;

}

/**
 * Unprocessable entity
 */
class CreateReaderCheckoutUnprocessableEntity
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * Error description
 */
class CreateReaderTerminateError
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * Unprocessable entity
 */
class CreateReaderTerminateUnprocessableEntity
{
    /**
     *
     * @var array
     */
    public array $errors;

}

/**
 * A physical card reader device that can accept in-person payments.
 */
class Reader
{
    /**
     * Unique identifier of the object.
     * Note that this identifies the instance of the physical devices pairing with your SumUp account.
     * If you DELETE a reader, and pair the device again, the ID will be different. Do not use this ID to refer to a physical device.
     *
     * @var ReaderId
     */
    public ReaderId $id;

    /**
     * Custom human-readable, user-defined name for easier identification of the reader.
     *
     * @var ReaderName
     */
    public ReaderName $name;

    /**
     * The status of the reader object gives information about the current state of the reader.
     * Possible values:
     * - `unknown` - The reader status is unknown.
     * - `processing` - The reader is created and waits for the physical device to confirm the pairing.
     * - `paired` - The reader is paired with a merchant account and can be used with SumUp APIs.
     * - `expired` - The pairing is expired and no longer usable with the account. The resource needs to get recreated.
     *
     * @var ReaderStatus
     */
    public ReaderStatus $status;

    /**
     * Information about the underlying physical device.
     *
     * @var ReaderDevice
     */
    public ReaderDevice $device;

    /**
     * A set of key-value pairs that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
     * **Warning**: Updating Meta will overwrite the existing data. Make sure to always include the complete JSON object.
     *
     * @var \SumUp\Shared\Meta|null
     */
    public ?\SumUp\Shared\Meta $meta = null;

    /**
     * The timestamp of when the reader was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the reader was last updated.
     *
     * @var string
     */
    public string $updatedAt;

}

/**
 * Information about the underlying physical device.
 */
class ReaderDevice
{
    /**
     * A unique identifier of the physical device (e.g. serial number).
     *
     * @var string
     */
    public string $identifier;

    /**
     * Identifier of the model of the device.
     *
     * @var string
     */
    public string $model;

}

/**
 * Unique identifier of the object.
 * Note that this identifies the instance of the physical devices pairing with your SumUp account.
 * If you DELETE a reader, and pair the device again, the ID will be different. Do not use this ID to refer to a physical device.
 */
class ReaderId
{
}

/**
 * Custom human-readable, user-defined name for easier identification of the reader.
 */
class ReaderName
{
}

/**
 * The pairing code is a 8 or 9 character alphanumeric string that is displayed on a SumUp Device after initiating the pairing. It is used to link the physical device to the created pairing.
 */
class ReaderPairingCode
{
}

/**
 * The status of the reader object gives information about the current state of the reader.
 *
 * Possible values:
 *
 * - `unknown` - The reader status is unknown.
 * - `processing` - The reader is created and waits for the physical device to confirm the pairing.
 * - `paired` - The reader is paired with a merchant account and can be used with SumUp APIs.
 * - `expired` - The pairing is expired and no longer usable with the account. The resource needs to get recreated.
 */
class ReaderStatus
{
}
