<?php

declare(strict_types=1);

namespace SumUp\Customers;

class Customer
{
    /**
     * Unique ID of the customer.
     *
     * @var string
     */
    public string $customerId;

    /**
     * Personal details for the customer.
     *
     * @var \SumUp\Shared\PersonalDetails|null
     */
    public ?\SumUp\Shared\PersonalDetails $personalDetails = null;

}

/**
 * Payment Instrument Response
 */
class PaymentInstrumentResponse
{
    /**
     * Unique token identifying the saved payment card for a customer.
     *
     * @var string|null
     */
    public ?string $token = null;

    /**
     * Indicates whether the payment instrument is active and can be used for payments. To deactivate it, send a `DELETE` request to the resource endpoint.
     *
     * @var bool|null
     */
    public ?bool $active = null;

    /**
     * Type of the payment instrument.
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * Details of the payment card.
     *
     * @var array|null
     */
    public ?array $card = null;

    /**
     * Created mandate
     *
     * @var \SumUp\Shared\MandateResponse|null
     */
    public ?\SumUp\Shared\MandateResponse $mandate = null;

    /**
     * Creation date of payment instrument. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $createdAt = null;

}
