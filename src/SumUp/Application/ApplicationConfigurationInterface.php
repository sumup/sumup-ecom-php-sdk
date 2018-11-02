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
    public function getAppId();

    /**
     * Returns application's secret.
     *
     * @return string
     */
    public function getAppSecret();

    /**
     * Returns the scopes formatted as they should appear in the request.
     *
     * @return string
     */
    public function getScopes();

    /**
     * Returns the base URL of the SumUp API.
     *
     * @return string
     */
    public function getBaseURL();

    /**
     * Returns authorization code.
     *
     * @return string
     */
    public function getCode();

    /**
     * Returns grant type.
     *
     * @return string
     */
    public function getGrantType();

    /**
     * Returns merchant's username;
     *
     * @return string
     */
    public function getUsername();

    /**
     * Returns merchant's passowrd;
     *
     * @return string
     */
    public function getPassword();
}
