<?php

declare(strict_types=1);

namespace SumUp\Merchants;

/**
 * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
 * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
 */
class Address
{
    /**
     *
     * @var string[]|null
     */
    public ?array $streetAddress = null;

    /**
     * The postal code (aka. zip code) of the address.
     *
     * @var string|null
     */
    public ?string $postCode = null;

    /**
     * An [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
     * country code. This definition users `oneOf` with a two-character string
     * type to allow for support of future countries in client code.
     *
     * @var CountryCode
     */
    public CountryCode $country;

    /**
     * The city of the address.
     *
     * @var string|null
     */
    public ?string $city = null;

    /**
     * The province where the address is located. This may not be relevant in some countries.
     *
     * @var string|null
     */
    public ?string $province = null;

    /**
     * The region where the address is located. This may not be relevant in some countries.
     *
     * @var string|null
     */
    public ?string $region = null;

    /**
     * A county is a geographic region of a country used for administrative or other purposes in some nations. Used in countries such as Ireland, Romania, etc.
     *
     * @var string|null
     */
    public ?string $county = null;

    /**
     * In Spain, an autonomous community is the first sub-national level of political and administrative division.
     *
     * @var string|null
     */
    public ?string $autonomousCommunity = null;

    /**
     * A post town is a required part of all postal addresses in the United Kingdom and Ireland, and a basic unit of the postal delivery system.
     *
     * @var string|null
     */
    public ?string $postTown = null;

    /**
     * Most often, a country has a single state, with various administrative divisions. The term "state" is sometimes used to refer to the federated polities that make up the federation. Used in countries such as the United States and Brazil.
     *
     * @var string|null
     */
    public ?string $state = null;

    /**
     * Locality level of the address. Used in countries such as Brazil or Chile.
     *
     * @var string|null
     */
    public ?string $neighborhood = null;

    /**
     * In many countries, terms cognate with "commune" are used, referring to the community living in the area and the common interest. Used in countries such as Chile.
     *
     * @var string|null
     */
    public ?string $commune = null;

    /**
     * A department (French: département, Spanish: departamento) is an administrative or political division in several countries. Used in countries such as Colombia.
     *
     * @var string|null
     */
    public ?string $department = null;

    /**
     * A municipality is usually a single administrative division having corporate status and powers of self-government or jurisdiction as granted by national and regional laws to which it is subordinate. Used in countries such as Colombia.
     *
     * @var string|null
     */
    public ?string $municipality = null;

    /**
     * A district is a type of administrative division that in some countries is managed by the local government. Used in countries such as Portugal.
     *
     * @var string|null
     */
    public ?string $district = null;

    /**
     * A US system of postal codes used by the United States Postal Service (USPS).
     *
     * @var string|null
     */
    public ?string $zipCode = null;

    /**
     * A postal address in Ireland.
     *
     * @var string|null
     */
    public ?string $eircode = null;

}

class BaseError
{
    /**
     * A unique identifier for the error instance. This can be used to trace the error back to the server logs.
     *
     * @var string|null
     */
    public ?string $instance = null;

    /**
     * A human-readable message describing the error that occurred.
     *
     * @var string|null
     */
    public ?string $message = null;

}

/**
 * Base schema for a person associated with a merchant. This can be a legal representative, business owner (ultimate beneficial owner), or an officer. A legal representative is the person who registered the merchant with SumUp. They should always have a `user_id`.
 *
 */
class BasePerson
{
    /**
     * The unique identifier for the person. This is a [typeid](https://github.com/sumup/typeid).
     *
     * @var string
     */
    public string $id;

    /**
     * A corresponding identity user ID for the person, if they have a user account.
     *
     * @var string|null
     */
    public ?string $userId = null;

    /**
     * The date of birth of the individual, represented as an ISO 8601:2004 [ISO8601‑2004] YYYY-MM-DD format.
     *
     * @var string|null
     */
    public ?string $birthdate = null;

    /**
     * The first name(s) of the individual.
     *
     * @var string|null
     */
    public ?string $givenName = null;

    /**
     * The last name(s) of the individual.
     *
     * @var string|null
     */
    public ?string $familyName = null;

    /**
     * Middle name(s) of the End-User. Note that in some cultures, people can have multiple middle names; all can be present, with the names being separated by space characters. Also note that in some cultures, middle names are not used.
     *
     * @var string|null
     */
    public ?string $middleName = null;

    /**
     * A publicly available phone number in [E.164](https://en.wikipedia.org/wiki/E.164) format.
     *
     * @var PhoneNumber|null
     */
    public ?PhoneNumber $phoneNumber = null;

    /**
     * A list of roles the person has in the merchant or towards SumUp. A merchant must have at least one person with the relationship `representative`.
     *
     * @var string[]|null
     */
    public ?array $relationships = null;

    /**
     *
     * @var Ownership|null
     */
    public ?Ownership $ownership = null;

    /**
     * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
     * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
     *
     * @var Address|null
     */
    public ?Address $address = null;

    /**
     * A list of country-specific personal identifiers.
     *
     * @var PersonalIdentifier[]|null
     */
    public ?array $identifiers = null;

    /**
     * An [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
     * country code. This definition users `oneOf` with a two-character string
     * type to allow for support of future countries in client code.
     *
     * @var CountryCode|null
     */
    public ?CountryCode $citizenship = null;

    /**
     * The persons nationality. May be an [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) country code, but legacy data may not conform to this standard.
     *
     * @var string|null
     */
    public ?string $nationality = null;

    /**
     * An [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) country code representing the country where the person resides.
     *
     * @var string|null
     */
    public ?string $countryOfResidence = null;

    /**
     * The version of the resource. The version reflects a specific change submitted to the API via one of the `PATCH` endpoints.
     *
     * @var Version|null
     */
    public ?Version $version = null;

    /**
     * Reflects the status of changes submitted through the `PATCH` endpoints for the merchant or persons. If some changes have not been applied yet, the status will be `pending`. If all changes have been applied, the status `done`.
     * The status is only returned after write operations or on read endpoints when the `version` query parameter is provided.
     *
     * @var ChangeStatus|null
     */
    public ?ChangeStatus $changeStatus = null;

}

/**
 * Settings used to apply the Merchant's branding to email receipts, invoices, checkouts, and other products.
 */
class Branding
{
    /**
     * An icon for the merchant. Must be square.
     *
     * @var string|null
     */
    public ?string $icon = null;

    /**
     * A logo for the merchant that will be used in place of the icon and without the merchant's name next to it if there's sufficient space.
     *
     * @var string|null
     */
    public ?string $logo = null;

    /**
     * Data-URL encoded hero image for the merchant business.
     *
     * @var string|null
     */
    public ?string $hero = null;

    /**
     * A hex color value representing the primary branding color of this merchant (your brand color).
     *
     * @var string|null
     */
    public ?string $primaryColor = null;

    /**
     * A hex color value representing the color of the text displayed on branding color of this merchant.
     *
     * @var string|null
     */
    public ?string $primaryColorFg = null;

    /**
     * A hex color value representing the secondary branding color of this merchant (accent color used for buttons).
     *
     * @var string|null
     */
    public ?string $secondaryColor = null;

    /**
     * A hex color value representing the color of the text displayed on secondary branding color of this merchant.
     *
     * @var string|null
     */
    public ?string $secondaryColorFg = null;

    /**
     * A hex color value representing the preferred background color of this merchant.
     *
     * @var string|null
     */
    public ?string $backgroundColor = null;

}

/**
 * Business information about the merchant. This information will be visible to the merchant's customers.
 *
 */
class BusinessProfile
{
    /**
     * The customer-facing business name.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The descriptor is the text that your customer sees on their bank account statement.
     * The more recognisable your descriptor is, the less risk you have of receiving disputes (e.g. chargebacks).
     *
     * @var string|null
     */
    public ?string $dynamicDescriptor = null;

    /**
     * The business's publicly available website.
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     * A publicly available email address.
     *
     * @var string|null
     */
    public ?string $email = null;

    /**
     * A publicly available phone number in [E.164](https://en.wikipedia.org/wiki/E.164) format.
     *
     * @var PhoneNumber|null
     */
    public ?PhoneNumber $phoneNumber = null;

    /**
     * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
     * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
     *
     * @var Address|null
     */
    public ?Address $address = null;

    /**
     * Settings used to apply the Merchant's branding to email receipts, invoices, checkouts, and other products.
     *
     * @var Branding|null
     */
    public ?Branding $branding = null;

}

/**
 * Reflects the status of changes submitted through the `PATCH` endpoints for the merchant or persons. If some changes have not been applied yet, the status will be `pending`. If all changes have been applied, the status `done`.
 * The status is only returned after write operations or on read endpoints when the `version` query parameter is provided.
 *
 */
class ChangeStatus
{
}

class ClassicMerchantIdentifiers
{
    /**
     * Classic (serial) merchant ID.
     *
     * @var int
     */
    public int $id;

}

/**
 * Information about the company or business. This is legal information that is used for verification.
 *
 */
class Company
{
    /**
     * The company's legal name.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * The merchant category code for the account as specified by [ISO18245](https://www.iso.org/standard/33365.html). MCCs are used to classify businesses based on the goods or services they provide.
     *
     * @var string|null
     */
    public ?string $merchantCategoryCode = null;

    /**
     * The unique legal type reference as defined in the country SDK. We do not rely on IDs as used by other services. Consumers of this API are expected to use the country SDK to map to any other IDs, translation keys, or descriptions.
     *
     * @var LegalType|null
     */
    public ?LegalType $legalType = null;

    /**
     * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
     * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
     *
     * @var Address|null
     */
    public ?Address $address = null;

    /**
     * An address somewhere in the world. The address fields used depend on the country conventions. For example, in Great Britain, `city` is `post_town`. In the United States, the top-level administrative unit used in addresses is `state`, whereas in Chile it's `region`.
     * Whether an address is valid or not depends on whether the locally required fields are present. Fields not supported in a country will be ignored.
     *
     * @var Address|null
     */
    public ?Address $tradingAddress = null;

    /**
     * A list of country-specific company identifiers.
     *
     * @var CompanyIdentifiers|null
     */
    public ?CompanyIdentifiers $identifiers = null;

    /**
     * A publicly available phone number in [E.164](https://en.wikipedia.org/wiki/E.164) format.
     *
     * @var PhoneNumber|null
     */
    public ?PhoneNumber $phoneNumber = null;

    /**
     * HTTP(S) URL of the company's website.
     *
     * @var string|null
     */
    public ?string $website = null;

    /**
     * Object attributes that are modifiable only by SumUp applications.
     *
     * @var \SumUp\Shared\Attributes|null
     */
    public ?\SumUp\Shared\Attributes $attributes = null;

}

class CompanyIdentifier
{
    /**
     * The unique reference for the company identifier type as defined in the country SDK.
     *
     * @var string
     */
    public string $ref;

    /**
     * The company identifier value.
     *
     * @var string
     */
    public string $value;

}

/**
 * A list of country-specific company identifiers.
 *
 */
class CompanyIdentifiers
{
}

/**
 * An [ISO3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
 * country code. This definition users `oneOf` with a two-character string
 * type to allow for support of future countries in client code.
 */
class CountryCode
{
}

/**
 * The category of the error.
 *
 */
class ErrorCategoryClient
{
}

/**
 * The category of the error.
 *
 */
class ErrorCategoryServer
{
}

/**
 * An error code specifying the exact error that occurred.
 *
 */
class ErrorCodeInternalServerError
{
}

/**
 * An error code specifying the exact error that occurred.
 *
 */
class ErrorCodeNotFound
{
}

/**
 * The unique legal type reference as defined in the country SDK. We do not rely on IDs as used by other services. Consumers of this API are expected to use the country SDK to map to any other IDs, translation keys, or descriptions.
 *
 */
class LegalType
{
}

class ListPersonsResponseBody
{
    /**
     *
     * @var Person[]
     */
    public array $items;

}

class Merchant
{
}

class Ownership
{
    /**
     * The percent of ownership shares held by the person expressed in percent mille (1/100000). Only persons with the relationship `owner` can have ownership.
     *
     * @var int
     */
    public int $share;

}

class Person
{
}

class PersonalIdentifier
{
    /**
     * The unique reference for the personal identifier type.
     *
     * @var string
     */
    public string $ref;

    /**
     * The company identifier value.
     *
     * @var string
     */
    public string $value;

}

/**
 * A publicly available phone number in [E.164](https://en.wikipedia.org/wiki/E.164) format.
 *
 */
class PhoneNumber
{
}

class Timestamps
{
    /**
     * The date and time when the resource was created. This is a string as defined in [RFC 3339, section 5.6](https://datatracker.ietf.org/doc/html/rfc3339#section-5.6).
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The date and time when the resource was last updated. This is a string as defined in [RFC 3339, section 5.6](https://datatracker.ietf.org/doc/html/rfc3339#section-5.6).
     *
     * @var string
     */
    public string $updatedAt;

}

/**
 * The version of the resource. The version reflects a specific change submitted to the API via one of the `PATCH` endpoints.
 *
 */
class Version
{
}
