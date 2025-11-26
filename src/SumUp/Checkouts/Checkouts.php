<?php

declare(strict_types=1);

namespace SumUp\Checkouts;

/**
 * __Required when payment type is `card`.__ Details of the payment card.
 */
class Card
{
    /**
     * Name of the cardholder as it appears on the payment card.
     *
     * @var string
     */
    public string $name;

    /**
     * Number of the payment card (without spaces).
     *
     * @var string
     */
    public string $number;

    /**
     * Year from the expiration time of the payment card. Accepted formats are `YY` and `YYYY`.
     *
     * @var string
     */
    public string $expiryYear;

    /**
     * Month from the expiration time of the payment card. Accepted format is `MM`.
     *
     * @var string
     */
    public string $expiryMonth;

    /**
     * Three or four-digit card verification value (security code) of the payment card.
     *
     * @var string
     */
    public string $cvv;

    /**
     * Required five-digit ZIP code. Applicable only to merchant users in the USA.
     *
     * @var string|null
     */
    public ?string $zipCode = null;

    /**
     * Last 4 digits of the payment card number.
     *
     * @var string
     */
    public string $last4Digits;

    /**
     * Issuing card network of the payment card.
     *
     * @var string
     */
    public string $type;

}

/**
 * Details of the payment checkout.
 */
class Checkout
{
    /**
     * Unique ID of the payment checkout specified by the client application when creating the checkout resource.
     *
     * @var string|null
     */
    public ?string $checkoutReference = null;

    /**
     * Amount of the payment.
     *
     * @var float|null
     */
    public ?float $amount = null;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var \SumUp\Shared\Currency|null
     */
    public ?\SumUp\Shared\Currency $currency = null;

    /**
     * Unique identifying code of the merchant profile.
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Short description of the checkout visible in the SumUp dashboard. The description can contribute to reporting, allowing easier identification of a checkout.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * URL to which the SumUp platform sends the processing status of the payment checkout.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * Unique ID of the checkout resource.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Current status of the checkout.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Date and time of the creation of the payment checkout. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Date and time of the checkout expiration before which the client application needs to send a processing request. If no value is present, the checkout does not have an expiration time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * Unique identification of a customer. If specified, the checkout session and payment instrument are associated with the referenced customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Created mandate
     *
     * @var \SumUp\Shared\MandateResponse|null
     */
    public ?\SumUp\Shared\MandateResponse $mandate = null;

    /**
     * List of transactions related to the payment.
     *
     * @var mixed[]|null
     */
    public ?array $transactions = null;

}

/**
 * 3DS Response
 */
class CheckoutAccepted
{
    /**
     * Required action processing 3D Secure payments.
     *
     * @var array|null
     */
    public ?array $nextStep = null;

}

/**
 * Details of the payment checkout.
 */
class CheckoutCreateRequest
{
    /**
     * Unique ID of the payment checkout specified by the client application when creating the checkout resource.
     *
     * @var string
     */
    public string $checkoutReference;

    /**
     * Amount of the payment.
     *
     * @var float
     */
    public float $amount;

    /**
     * Three-letter [ISO4217](https://en.wikipedia.org/wiki/ISO_4217) code of the currency for the amount. Currently supported currency values are enumerated above.
     *
     * @var \SumUp\Shared\Currency
     */
    public \SumUp\Shared\Currency $currency;

    /**
     * Unique identifying code of the merchant profile.
     *
     * @var string
     */
    public string $merchantCode;

    /**
     * Short description of the checkout visible in the SumUp dashboard. The description can contribute to reporting, allowing easier identification of a checkout.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * URL to which the SumUp platform sends the processing status of the payment checkout.
     *
     * @var string|null
     */
    public ?string $returnUrl = null;

    /**
     * Unique identification of a customer. If specified, the checkout session and payment instrument are associated with the referenced customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Purpose of the checkout.
     *
     * @var string|null
     */
    public ?string $purpose = null;

    /**
     * Unique ID of the checkout resource.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Current status of the checkout.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Date and time of the creation of the payment checkout. Response format expressed according to [ISO8601](https://en.wikipedia.org/wiki/ISO_8601) code.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Date and time of the checkout expiration before which the client application needs to send a processing request. If no value is present, the checkout does not have an expiration time.
     *
     * @var string|null
     */
    public ?string $validUntil = null;

    /**
     * List of transactions related to the payment.
     *
     * @var mixed[]|null
     */
    public ?array $transactions = null;

    /**
     * __Required__ for [APMs](https://developer.sumup.com/online-payments/apm/introduction) and __recommended__ for card payments. Refers to a url where the end user is redirected once the payment processing completes. If not specified, the [Payment Widget](https://developer.sumup.com/online-payments/tools/card-widget) renders [3DS challenge](https://developer.sumup.com/online-payments/features/3ds) within an iframe instead of performing a full-page redirect.
     *
     * @var string|null
     */
    public ?string $redirectUrl = null;

}

class CheckoutSuccess
{
}

/**
 * Error message structure.
 */
class DetailsError
{
    /**
     * Short title of the error.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * Details of the error.
     *
     * @var string|null
     */
    public ?string $details = null;

    /**
     * The status code.
     *
     * @var float|null
     */
    public ?float $status = null;

    /**
     *
     * @var array[]|null
     */
    public ?array $failedConstraints = null;

}

class ErrorExtended
{
}

/**
 * Mandate is passed when a card is to be tokenized
 */
class MandatePayload
{
    /**
     * Indicates the mandate type
     *
     * @var string
     */
    public string $type;

    /**
     * Operating system and web client used by the end-user
     *
     * @var string
     */
    public string $userAgent;

    /**
     * IP address of the end user. Supports IPv4 and IPv6
     *
     * @var string|null
     */
    public ?string $userIp = null;

}

/**
 * Details of the payment instrument for processing the checkout.
 */
class ProcessCheckout
{
    /**
     * Describes the payment method used to attempt processing
     *
     * @var string
     */
    public string $paymentType;

    /**
     * Number of installments for deferred payments. Available only to merchant users in Brazil.
     *
     * @var int|null
     */
    public ?int $installments = null;

    /**
     * Mandate is passed when a card is to be tokenized
     *
     * @var MandatePayload|null
     */
    public ?MandatePayload $mandate = null;

    /**
     * __Required when payment type is `card`.__ Details of the payment card.
     *
     * @var Card|null
     */
    public ?Card $card = null;

    /**
     * __Required when using a tokenized card to process a checkout.__ Unique token identifying the saved payment card for a customer.
     *
     * @var string|null
     */
    public ?string $token = null;

    /**
     * __Required when `token` is provided.__ Unique ID of the customer.
     *
     * @var string|null
     */
    public ?string $customerId = null;

    /**
     * Personal details for the customer.
     *
     * @var \SumUp\Shared\PersonalDetails|null
     */
    public ?\SumUp\Shared\PersonalDetails $personalDetails = null;

}
