<?php

namespace SumUp\Application;

/**
 * Interface ApplicationConfigurationInterface
 *
 * @package SumUp\Application
 */
interface ApplicationConfigurationInterface
{
    /**
     * Returns application's ID.
     *
     * @return string
     */
    public function getAppId(): string;

    /**
     * Returns application's secret.
     *
     * @return string
     */
    public function getAppSecret(): string;

    /**
     * Returns the scopes formatted as they should appear in the request.
     *
     * @return array
     */
    public function getScopes(): array;

    /**
     * Returns the base URL of the SumUp API.
     *
     * @return string
     */
    public function getBaseURL(): string;

    /**
     * Returns authorization code.
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Returns grant type.
     *
     * @return string
     */
    public function getGrantType(): string;

    /**
     * Returns merchant's username;
     *
     * @return string
     */
    public function getUsername(): string;

    /**
     * Returns merchant's password;
     *
     * @return string
     */
    public function getPassword(): string;

    /**
     * Returns access token.
     *
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * Returns refresh token.
     *
     * @return string
     */
    public function getRefreshToken(): ?string;

    /**
     * Returns a flag whether to use GuzzleHttp over cURL if both are present.
     *
     * @return bool
     */
    public function getForceGuzzle(): bool;

    /**
     * Returns associative array with custom headers.
     *
     * @return array
     */
    public function getCustomHeaders(): array;

    /**
     * Returns the path to the CA bundle used for HTTPS verification.
     *
     * @return string|null
     */
    public function getCABundlePath(): ?string;

    /**
     * Returns the API key if set.
     *
     * @return string|null
     */
    public function getApiKey(): ?string;
}
