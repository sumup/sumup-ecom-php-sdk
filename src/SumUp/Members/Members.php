<?php

declare(strict_types=1);

namespace SumUp\Members;

/**
 * A member is user within specific resource identified by resource id, resource type, and associated roles.
 */
class Member
{
    /**
     * ID of the member.
     *
     * @var string
     */
    public string $id;

    /**
     * User's roles.
     *
     * @var string[]
     */
    public array $roles;

    /**
     * User's permissions.
     *
     * @var string[]
     */
    public array $permissions;

    /**
     * The timestamp of when the member was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the member was last updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * Information about the user associated with the membership.
     *
     * @var MembershipUser|null
     */
    public ?MembershipUser $user = null;

    /**
     * Pending invitation for membership.
     *
     * @var \SumUp\Shared\Invite|null
     */
    public ?\SumUp\Shared\Invite $invite = null;

    /**
     * The status of the membership.
     *
     * @var \SumUp\Shared\MembershipStatus
     */
    public \SumUp\Shared\MembershipStatus $status;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata.
     *
     * @var \SumUp\Shared\Metadata|null
     */
    public ?\SumUp\Shared\Metadata $metadata = null;

    /**
     * Object attributes that are modifiable only by SumUp applications.
     *
     * @var \SumUp\Shared\Attributes|null
     */
    public ?\SumUp\Shared\Attributes $attributes = null;

}

/**
 * Information about the user associated with the membership.
 */
class MembershipUser
{
    /**
     * Identifier for the End-User (also called Subject).
     *
     * @var string
     */
    public string $id;

    /**
     * End-User's preferred e-mail address. Its value MUST conform to the RFC 5322 [RFC5322] addr-spec syntax. The RP MUST NOT rely upon this value being unique, for unique identification use ID instead.
     *
     * @var string
     */
    public string $email;

    /**
     * True if the user has enabled MFA on login.
     *
     * @var bool
     */
    public bool $mfaOnLoginEnabled;

    /**
     * True if the user is a virtual user (operator).
     *
     * @var bool
     */
    public bool $virtualUser;

    /**
     * True if the user is a service account.
     *
     * @var bool
     */
    public bool $serviceAccountUser;

    /**
     * Time when the user has been disabled. Applies only to virtual users (`virtual_user: true`).
     *
     * @var string|null
     */
    public ?string $disabledAt = null;

    /**
     * User's preferred name. Used for display purposes only.
     *
     * @var string|null
     */
    public ?string $nickname = null;

    /**
     * URL of the End-User's profile picture. This URL refers to an image file (for example, a PNG, JPEG, or GIF image file), rather than to a Web page containing an image.
     *
     * @var string|null
     */
    public ?string $picture = null;

    /**
     * Classic identifiers of the user.
     *
     * @var MembershipUserClassic|null
     */
    public ?MembershipUserClassic $classic = null;

}

/**
 * Classic identifiers of the user.
 */
class MembershipUserClassic
{
    /**
     *
     * @var int
     */
    public int $userId;

}
