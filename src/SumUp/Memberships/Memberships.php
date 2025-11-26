<?php

declare(strict_types=1);

namespace SumUp\Memberships;

/**
 * A membership associates a user with a resource, memberships is defined by user, resource, resource type, and associated roles.
 */
class Membership
{
    /**
     * ID of the membership.
     *
     * @var string
     */
    public string $id;

    /**
     * ID of the resource the membership is in.
     *
     * @var string
     */
    public string $resourceId;

    /**
     * The type of the membership resource.
     * Possible values are:
     * * `merchant` - merchant account(s)
     * * `organization` - organization(s)
     *
     * @var ResourceType
     */
    public ResourceType $type;

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
     * The timestamp of when the membership was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the membership was last updated.
     *
     * @var string
     */
    public string $updatedAt;

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

    /**
     * Information about the resource the membership is in.
     *
     * @var MembershipResource
     */
    public MembershipResource $resource;

}

/**
 * Information about the resource the membership is in.
 */
class MembershipResource
{
    /**
     * ID of the resource the membership is in.
     *
     * @var string
     */
    public string $id;

    /**
     * The type of the membership resource.
     * Possible values are:
     * * `merchant` - merchant account(s)
     * * `organization` - organization(s)
     *
     * @var ResourceType
     */
    public ResourceType $type;

    /**
     * Display name of the resource.
     *
     * @var string
     */
    public string $name;

    /**
     * Logo fo the resource.
     *
     * @var string|null
     */
    public ?string $logo = null;

    /**
     * The timestamp of when the membership resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the membership resource was last updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * Object attributes that are modifiable only by SumUp applications.
     *
     * @var \SumUp\Shared\Attributes|null
     */
    public ?\SumUp\Shared\Attributes $attributes = null;

}

/**
 * The type of the membership resource.
 * Possible values are:
 * * `merchant` - merchant account(s)
 * * `organization` - organization(s)
 */
class ResourceType
{
}
