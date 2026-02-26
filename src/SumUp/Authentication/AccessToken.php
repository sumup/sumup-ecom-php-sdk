<?php

namespace SumUp\Authentication;

/**
 * Class AccessToken
 *
 * @package SumUp\Authentication
 */
class AccessToken
{
    /**
     * The access token value.
     *
     * @var string
     */
    protected $value = '';

    /**
     * The access token type.
     *
     * @var string
     */
    protected $type = '';

    /**
     * The number of seconds the access token will be valid.
     *
     * @var int
     */
    protected $expiresIn;

    /**
     * The scopes for this access token.
     *
     * @var array
     */
    protected $scope;

    /**
     * The refresh token.
     *
     * @var string
     */
    protected $refreshToken;

    /**
     * Create a new access token entity.
     *
     * @param string $value
     * @param string $type
     * @param int|null    $expiresIn
     * @param array  $scope
     * @param string|null $refreshToken
     */
    public function __construct(string $value, string $type = '', ?int $expiresIn = -1, array $scope = [], ?string $refreshToken = null)
    {
        if ($value) {
            $this->value = $value;
        }
        if ($type) {
            $this->type = $type;
        }
        if ($expiresIn) {
            $this->expiresIn = $expiresIn;
        }
        if ($scope) {
            $this->scope = $scope;
        }
        if ($refreshToken) {
            $this->refreshToken = $refreshToken;
        }
    }

    /**
     * Returns the access token.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Returns the type of the access token.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the total number of seconds that the token will be valid.
     *
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * Returns the scopes for the current access token.
     *
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scope;
    }

    /**
     * Returns the refresh token if any.
     *
     * @return null|string
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }
}
