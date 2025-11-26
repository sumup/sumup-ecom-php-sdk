<?php

declare(strict_types=1);

namespace SumUp\Roles;

/**
 * A custom role that can be used to assign set of permissions to members.
 */
class Role
{
    /**
     * Unique identifier of the role.
     *
     * @var string
     */
    public string $id;

    /**
     * User-defined name of the role.
     *
     * @var string
     */
    public string $name;

    /**
     * User-defined description of the role.
     *
     * @var string|null
     */
    public ?string $description = null;

    /**
     * List of permission granted by this role.
     *
     * @var string[]
     */
    public array $permissions;

    /**
     * True if the role is provided by SumUp.
     *
     * @var bool
     */
    public bool $isPredefined;

    /**
     * Set of user-defined key-value pairs attached to the object. Partial updates are not supported. When updating, always submit whole metadata.
     *
     * @var \SumUp\Shared\Metadata|null
     */
    public ?\SumUp\Shared\Metadata $metadata = null;

    /**
     * The timestamp of when the role was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The timestamp of when the role was last updated.
     *
     * @var string
     */
    public string $updatedAt;

}
