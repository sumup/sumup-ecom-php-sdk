<?php

declare(strict_types=1);

namespace SumUp\Receipts;

class Receipt
{
    /**
     * Transaction information.
     *
     * @var ReceiptTransaction|null
     */
    public ?ReceiptTransaction $transactionData = null;

    /**
     * Receipt merchant data
     *
     * @var ReceiptMerchantData|null
     */
    public ?ReceiptMerchantData $merchantData = null;

    /**
     *
     * @var array|null
     */
    public ?array $emvData = null;

    /**
     *
     * @var array|null
     */
    public ?array $acquirerData = null;

}

class ReceiptCard
{
    /**
     * Card last 4 digits.
     *
     * @var string|null
     */
    public ?string $last4Digits = null;

    /**
     * Card Scheme.
     *
     * @var string|null
     */
    public ?string $type = null;

}

class ReceiptEvent
{
    /**
     * Unique ID of the transaction event.
     *
     * @var \SumUp\Shared\EventId|null
     */
    public ?\SumUp\Shared\EventId $id = null;

    /**
     * Unique ID of the transaction.
     *
     * @var \SumUp\Shared\TransactionId|null
     */
    public ?\SumUp\Shared\TransactionId $transactionId = null;

    /**
     * Type of the transaction event.
     *
     * @var \SumUp\Shared\EventType|null
     */
    public ?\SumUp\Shared\EventType $type = null;

    /**
     * Status of the transaction event.
     *
     * @var \SumUp\Shared\EventStatus|null
     */
    public ?\SumUp\Shared\EventStatus $status = null;

    /**
     * Amount of the event.
     *
     * @var \SumUp\Shared\AmountEvent|null
     */
    public ?\SumUp\Shared\AmountEvent $amount = null;

    /**
     * Date and time of the transaction event.
     *
     * @var \SumUp\Shared\TimestampEvent|null
     */
    public ?\SumUp\Shared\TimestampEvent $timestamp = null;

    /**
     *
     * @var string|null
     */
    public ?string $receiptNo = null;

}

/**
 * Receipt merchant data
 */
class ReceiptMerchantData
{
    /**
     *
     * @var array|null
     */
    public ?array $merchantProfile = null;

    /**
     *
     * @var string|null
     */
    public ?string $locale = null;

}

/**
 * Transaction information.
 */
class ReceiptTransaction
{
    /**
     * Transaction code.
     *
     * @var string|null
     */
    public ?string $transactionCode = null;

    /**
     * Transaction amount.
     *
     * @var string|null
     */
    public ?string $amount = null;

    /**
     * Transaction VAT amount.
     *
     * @var string|null
     */
    public ?string $vatAmount = null;

    /**
     * Tip amount (included in transaction amount).
     *
     * @var string|null
     */
    public ?string $tipAmount = null;

    /**
     * Transaction currency.
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     * Time created at.
     *
     * @var string|null
     */
    public ?string $timestamp = null;

    /**
     * Transaction processing status.
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * Transaction type.
     *
     * @var string|null
     */
    public ?string $paymentType = null;

    /**
     * Transaction entry mode.
     *
     * @var string|null
     */
    public ?string $entryMode = null;

    /**
     * Cardholder verification method.
     *
     * @var string|null
     */
    public ?string $verificationMethod = null;

    /**
     *
     * @var ReceiptCard|null
     */
    public ?ReceiptCard $card = null;

    /**
     * Number of installments.
     *
     * @var int|null
     */
    public ?int $installmentsCount = null;

    /**
     * Products
     *
     * @var array[]|null
     */
    public ?array $products = null;

    /**
     * Vat rates.
     *
     * @var array[]|null
     */
    public ?array $vatRates = null;

    /**
     * Events
     *
     * @var ReceiptEvent[]|null
     */
    public ?array $events = null;

    /**
     * Receipt number
     *
     * @var string|null
     */
    public ?string $receiptNo = null;

}
