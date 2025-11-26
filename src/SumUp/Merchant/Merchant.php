<?php

declare(strict_types=1);

namespace SumUp\Merchant;

/**
 * Profile information.
 */
class AccountLegacy
{
    /**
     * Username of the user profile.
     *
     * @var string|null
     */
    public ?string $username = null;

    /**
     * The role of the user.
     *
     * @var string|null
     */
    public ?string $type = null;

}

/**
 * Details of the registered address.
 */
class AddressWithDetails
{
    /**
     * Address line 1
     *
     * @var string|null
     */
    public ?string $addressLine1 = null;

    /**
     * Address line 2
     *
     * @var string|null
     */
    public ?string $addressLine2 = null;

    /**
     * City
     *
     * @var string|null
     */
    public ?string $city = null;

    /**
     * Country ISO 3166-1 code
     *
     * @var string|null
     */
    public ?string $country = null;

    /**
     * Country region id
     *
     * @var float|null
     */
    public ?float $regionId = null;

    /**
     * Region name
     *
     * @var string|null
     */
    public ?string $regionName = null;

    /**
     * Region code
     *
     * @var string|null
     */
    public ?string $regionCode = null;

    /**
     * Postal code
     *
     * @var string|null
     */
    public ?string $postCode = null;

    /**
     * Landline number
     *
     * @var string|null
     */
    public ?string $landline = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $company = null;

    /**
     * Country Details
     *
     * @var CountryDetails|null
     */
    public ?CountryDetails $countryDetails = null;

    /**
     * TimeOffset Details
     *
     * @var TimeoffsetDetails|null
     */
    public ?TimeoffsetDetails $timeoffsetDetails = null;

    /**
     * undefined
     *
     * @var string|null
     */
    public ?string $stateId = null;

}

/**
 * Mobile app settings
 */
class AppSettings
{
    /**
     * Checkout preference
     *
     * @var string|null
     */
    public ?string $checkoutPreference = null;

    /**
     * Include vat.
     *
     * @var bool|null
     */
    public ?bool $includeVat = null;

    /**
     * Manual entry tutorial.
     *
     * @var bool|null
     */
    public ?bool $manualEntryTutorial = null;

    /**
     * Mobile payment tutorial.
     *
     * @var bool|null
     */
    public ?bool $mobilePaymentTutorial = null;

    /**
     * Tax enabled.
     *
     * @var bool|null
     */
    public ?bool $taxEnabled = null;

    /**
     * Mobile payment.
     *
     * @var string|null
     */
    public ?string $mobilePayment = null;

    /**
     * Reader payment.
     *
     * @var string|null
     */
    public ?string $readerPayment = null;

    /**
     * Cash payment.
     *
     * @var string|null
     */
    public ?string $cashPayment = null;

    /**
     * Advanced mode.
     *
     * @var string|null
     */
    public ?string $advancedMode = null;

    /**
     * Expected max transaction amount.
     *
     * @var float|null
     */
    public ?float $expectedMaxTransactionAmount = null;

    /**
     * Manual entry.
     *
     * @var string|null
     */
    public ?string $manualEntry = null;

    /**
     * Terminal mode tutorial.
     *
     * @var bool|null
     */
    public ?bool $terminalModeTutorial = null;

    /**
     * Tipping.
     *
     * @var string|null
     */
    public ?string $tipping = null;

    /**
     * Tip rates.
     *
     * @var float[]|null
     */
    public ?array $tipRates = null;

    /**
     * Barcode scanner.
     *
     * @var string|null
     */
    public ?string $barcodeScanner = null;

    /**
     * Referral.
     *
     * @var string|null
     */
    public ?string $referral = null;

}

class BankAccount
{
    /**
     * Bank code
     *
     * @var string|null
     */
    public ?string $bankCode = null;

    /**
     * Branch code
     *
     * @var string|null
     */
    public ?string $branchCode = null;

    /**
     * SWIFT code
     *
     * @var string|null
     */
    public ?string $swift = null;

    /**
     * Account number
     *
     * @var string|null
     */
    public ?string $accountNumber = null;

    /**
     * IBAN
     *
     * @var string|null
     */
    public ?string $iban = null;

    /**
     * Type of the account
     *
     * @var string|null
     */
    public ?string $accountType = null;

    /**
     * Account category - business or personal
     *
     * @var string|null
     */
    public ?string $accountCategory = null;

    /**
     *
     * @var string|null
     */
    public ?string $accountHolderName = null;

    /**
     * Status in the verification process
     *
     * @var string|null
     */
    public ?string $status = null;

    /**
     * The primary bank account is the one used for payouts
     *
     * @var bool|null
     */
    public ?bool $primary = null;

    /**
     * Creation date of the bank account
     *
     * @var string|null
     */
    public ?string $createdAt = null;

    /**
     * Bank name
     *
     * @var string|null
     */
    public ?string $bankName = null;

}

/**
 * Business owners information.
 */
class BusinessOwners
{
}

/**
 * Country Details
 */
class CountryDetails
{
    /**
     * Currency ISO 4217 code
     *
     * @var string|null
     */
    public ?string $currency = null;

    /**
     * Country ISO code
     *
     * @var string|null
     */
    public ?string $isoCode = null;

    /**
     * Country EN name
     *
     * @var string|null
     */
    public ?string $enName = null;

    /**
     * Country native name
     *
     * @var string|null
     */
    public ?string $nativeName = null;

}

/**
 * Doing Business As information
 */
class DoingBusinessAsLegacy
{
    /**
     * Doing business as name
     *
     * @var string|null
     */
    public ?string $businessName = null;

    /**
     * Doing business as company registration number
     *
     * @var string|null
     */
    public ?string $companyRegistrationNumber = null;

    /**
     * Doing business as VAT ID
     *
     * @var string|null
     */
    public ?string $vatId = null;

    /**
     * Doing business as website
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     * Doing business as email
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     *
     * @var array|null
     */
    public ?array $address = null;

}

/**
 * Id of the legal type of the merchant profile
 */
class LegalTypeLegacy
{
    /**
     * Unique id
     *
     * @var float|null
     */
    public ?float $id = null;

    /**
     * Legal type description
     *
     * @var string|null
     */
    public ?string $fullDescription = null;

    /**
     * Legal type short description
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Sole trader legal type if true
     *
     * @var bool|null
     */
    public ?bool $soleTrader = null;

}

/**
 * Details of the merchant account.
 */
class MerchantAccount
{
    /**
     * Profile information.
     *
     * @var AccountLegacy|null
     */
    public ?AccountLegacy $account = null;

    /**
     * Account's personal profile.
     *
     * @var PersonalProfileLegacy|null
     */
    public ?PersonalProfileLegacy $personalProfile = null;

    /**
     * Account's merchant profile
     *
     * @var MerchantProfileLegacy|null
     */
    public ?MerchantProfileLegacy $merchantProfile = null;

    /**
     * Mobile app settings
     *
     * @var AppSettings|null
     */
    public ?AppSettings $appSettings = null;

    /**
     * User permissions
     *
     * @var PermissionsLegacy|null
     */
    public ?PermissionsLegacy $permissions = null;

}

/**
 * Account's merchant profile
 */
class MerchantProfileLegacy
{
    /**
     * Unique identifying code of the merchant profile
     *
     * @var string|null
     */
    public ?string $merchantCode = null;

    /**
     * Company name
     *
     * @var string|null
     */
    public ?string $companyName = null;

    /**
     * Website
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     * Id of the legal type of the merchant profile
     *
     * @var LegalTypeLegacy|null
     */
    public ?LegalTypeLegacy $legalType = null;

    /**
     * Merchant category code
     *
     * @var string|null
     */
    public ?string $merchantCategoryCode = null;

    /**
     * Mobile phone number
     *
     * @var string|null
     */
    public ?string $mobilePhone = null;

    /**
     * Company registration number
     *
     * @var string|null
     */
    public ?string $companyRegistrationNumber = null;

    /**
     * Vat ID
     *
     * @var string|null
     */
    public ?string $vatId = null;

    /**
     * Permanent certificate access code &#40;Portugal&#41;
     *
     * @var string|null
     */
    public ?string $permanentCertificateAccessCode = null;

    /**
     * Nature and purpose of the business
     *
     * @var string|null
     */
    public ?string $natureAndPurpose = null;

    /**
     * Details of the registered address.
     *
     * @var AddressWithDetails|null
     */
    public ?AddressWithDetails $address = null;

    /**
     * Business owners information.
     *
     * @var BusinessOwners|null
     */
    public ?BusinessOwners $businessOwners = null;

    /**
     * Doing Business As information
     *
     * @var DoingBusinessAsLegacy|null
     */
    public ?DoingBusinessAsLegacy $doingBusinessAs = null;

    /**
     * Merchant settings &#40;like \"payout_type\", \"payout_period\"&#41;
     *
     * @var MerchantSettings|null
     */
    public ?MerchantSettings $settings = null;

    /**
     * Merchant VAT rates
     *
     * @var VatRates|null
     */
    public ?VatRates $vatRates = null;

    /**
     * Merchant locale &#40;for internal usage only&#41;
     *
     * @var string|null
     */
    public ?string $locale = null;

    /**
     *
     * @var BankAccount[]|null
     */
    public ?array $bankAccounts = null;

    /**
     * True if the merchant is extdev
     *
     * @var bool|null
     */
    public ?bool $extdev = null;

    /**
     * True if the payout zone of this merchant is migrated
     *
     * @var bool|null
     */
    public ?bool $payoutZoneMigrated = null;

    /**
     * Merchant country code formatted according to [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) &#40;for internal usage only&#41;
     *
     * @var string|null
     */
    public ?string $country = null;

}

/**
 * Merchant settings &#40;like \"payout_type\", \"payout_period\"&#41;
 */
class MerchantSettings
{
    /**
     * Whether to show tax in receipts &#40;saved per transaction&#41;
     *
     * @var bool|null
     */
    public ?bool $taxEnabled = null;

    /**
     * Payout type
     *
     * @var string|null
     */
    public ?string $payoutType = null;

    /**
     * Payout frequency
     *
     * @var string|null
     */
    public ?string $payoutPeriod = null;

    /**
     * Whether merchant can edit payouts on demand
     *
     * @var bool|null
     */
    public ?bool $payoutOnDemandAvailable = null;

    /**
     * Whether merchant will receive payouts on demand
     *
     * @var bool|null
     */
    public ?bool $payoutOnDemand = null;

    /**
     * Whether to show printers in mobile app
     *
     * @var bool|null
     */
    public ?bool $printersEnabled = null;

    /**
     * Payout Instrument
     *
     * @var string|null
     */
    public ?string $payoutInstrument = null;

    /**
     * Whether merchant can make MOTO payments
     *
     * @var string|null
     */
    public ?string $motoPayment = null;

    /**
     * Stone merchant code
     *
     * @var string|null
     */
    public ?string $stoneMerchantCode = null;

    /**
     * Whether merchant will receive daily payout emails
     *
     * @var bool|null
     */
    public ?bool $dailyPayoutEmail = null;

    /**
     * Whether merchant will receive monthly payout emails
     *
     * @var bool|null
     */
    public ?bool $monthlyPayoutEmail = null;

    /**
     * Whether merchant has gross settlement enabled
     *
     * @var bool|null
     */
    public ?bool $grossSettlement = null;

}

/**
 * User permissions
 */
class PermissionsLegacy
{
    /**
     * Create MOTO payments
     *
     * @var bool|null
     */
    public ?bool $createMotoPayments = null;

    /**
     * Can view full merchant transaction history
     *
     * @var bool|null
     */
    public ?bool $fullTransactionHistoryView = null;

    /**
     * Refund transactions
     *
     * @var bool|null
     */
    public ?bool $refundTransactions = null;

    /**
     * Create referral
     *
     * @var bool|null
     */
    public ?bool $createReferral = null;

}

/**
 * Account's personal profile.
 */
class PersonalProfileLegacy
{
    /**
     * First name of the user
     *
     * @var string|null
     */
    public ?string $firstName = null;

    /**
     * Last name of the user
     *
     * @var string|null
     */
    public ?string $lastName = null;

    /**
     * Date of birth
     *
     * @var string|null
     */
    public ?string $dateOfBirth = null;

    /**
     * Mobile phone number
     *
     * @var string|null
     */
    public ?string $mobilePhone = null;

    /**
     * Details of the registered address.
     *
     * @var AddressWithDetails|null
     */
    public ?AddressWithDetails $address = null;

    /**
     *
     * @var bool|null
     */
    public ?bool $complete = null;

}

/**
 * TimeOffset Details
 */
class TimeoffsetDetails
{
    /**
     * Postal code
     *
     * @var string|null
     */
    public ?string $postCode = null;

    /**
     * UTC offset
     *
     * @var float|null
     */
    public ?float $offset = null;

    /**
     * Daylight Saving Time
     *
     * @var bool|null
     */
    public ?bool $dst = null;

}

/**
 * Merchant VAT rates
 */
class VatRates
{
    /**
     * Internal ID
     *
     * @var float|null
     */
    public ?float $id = null;

    /**
     * Description
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * Rate
     *
     * @var float|null
     */
    public ?float $rate = null;

    /**
     * Ordering
     *
     * @var float|null
     */
    public ?float $ordering = null;

    /**
     * Country ISO code
     *
     * @var string|null
     */
    public ?string $country = null;

}
