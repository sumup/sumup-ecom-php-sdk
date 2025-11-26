<?php

declare(strict_types=1);

namespace SumUp\Transactions;

/**
 * Details of the payment card.
 */
class CardResponse
{
    /**
     * Last 4 digits of the payment card number.
     *
     * @var string|null
     */
    public ?string $last4Digits = null;

    /**
     * Issuing card network of the payment card.
     *
     * @var string|null
     */
    public ?string $type = null;

}

class Event
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
     * Amount of the fee related to the event.
     *
     * @var float|null
     */
    public ?float $feeAmount = null;

    /**
     * Consecutive number of the installment.
     *
     * @var int|null
     */
    public ?int $installmentNumber = null;

    /**
     * Amount deducted for the event.
     *
     * @var float|null
     */
    public ?float $deductedAmount = null;

    /**
     * Amount of the fee deducted for the event.
     *
     * @var float|null
     */
    public ?float $deductedFeeAmount = null;

}

/**
 * Indication of the precision of the geographical position received from the payment terminal.
 */
class HorizontalAccuracy
{
}

/**
 * Latitude value from the coordinates of the payment location (as received from the payment terminal reader).
 */
class Lat
{
}

/**
 * Details of a link to a related resource.
 */
class Link
{
    /**
     * Specifies the relation to the current resource.
     *
     * @var string|null
     */
    public ?string $rel = null;

    /**
     * URL for accessing the related resource.
     *
     * @var string|null
     */
    public ?string $href = null;

    /**
     * Specifies the media type of the related resource.
     *
     * @var string|null
     */
    public ?string $type = null;

}

class LinkRefund
{
}

/**
 * Longitude value from the coordinates of the payment location (as received from the payment terminal reader).
 */
class Lon
{
}

/**
 * Details of the product for which the payment is made.
 */
class Product
{
    /**
     * Name of the product from the merchant's catalog.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Price of the product without VAT.
     *
     * @var float|null
     */
    public ?float $price = null;

    /**
     * VAT rate applicable to the product.
     *
     * @var float|null
     */
    public ?float $vatRate = null;

    /**
     * Amount of the VAT for a single product item (calculated as the product of `price` and `vat_rate`, i.e. `single_vat_amount = price * vat_rate`).
     *
     * @var float|null
     */
    public ?float $singleVatAmount = null;

    /**
     * Price of a single product item with VAT.
     *
     * @var float|null
     */
    public ?float $priceWithVat = null;

    /**
     * Total VAT amount for the purchase (calculated as the product of `single_vat_amount` and `quantity`, i.e. `vat_amount = single_vat_amount * quantity`).
     *
     * @var float|null
     */
    public ?float $vatAmount = null;

    /**
     * Number of product items for the purchase.
     *
     * @var float|null
     */
    public ?float $quantity = null;

    /**
     * Total price of the product items without VAT (calculated as the product of `price` and `quantity`, i.e. `total_price = price * quantity`).
     *
     * @var float|null
     */
    public ?float $totalPrice = null;

    /**
     * Total price of the product items including VAT (calculated as the product of `price_with_vat` and `quantity`, i.e. `total_with_vat = price_with_vat * quantity`).
     *
     * @var float|null
     */
    public ?float $totalWithVat = null;

}

/**
 * Details of a transaction event.
 */
class TransactionEvent
{
    /**
     * Unique ID of the transaction event.
     *
     * @var \SumUp\Shared\EventId|null
     */
    public ?\SumUp\Shared\EventId $id = null;

    /**
     * Type of the transaction event.
     *
     * @var \SumUp\Shared\EventType|null
     */
    public ?\SumUp\Shared\EventType $eventType = null;

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
     * Date when the transaction event is due to occur.
     *
     * @var string|null
     */
    public ?string $dueDate = null;

    /**
     * Date when the transaction event occurred.
     *
     * @var string|null
     */
    public ?string $date = null;

    /**
     * Consecutive number of the installment that is paid. Applicable only payout events, i.e. `event_type = PAYOUT`.
     *
     * @var int|null
     */
    public ?int $installmentNumber = null;

    /**
     * Date and time of the transaction event.
     *
     * @var \SumUp\Shared\TimestampEvent|null
     */
    public ?\SumUp\Shared\TimestampEvent $timestamp = null;

}

class TransactionFull
{
}

class TransactionHistory
{
}

class TransactionMixinHistory
{
    /**
     * Short description of the payment. The value is taken from the `description` property of the related checkout resource.
     *
     * @var string|null
     */
    public ?string $productSummary = null;

    /**
     * Total number of payouts to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsTotal = null;

    /**
     * Number of payouts that are made to the registered user specified in the `user` property.
     *
     * @var int|null
     */
    public ?int $payoutsReceived = null;

    /**
     * Payout plan of the registered user at the time when the transaction was made.
     *
     * @var string|null
     */
    public ?string $payoutPlan = null;

}
