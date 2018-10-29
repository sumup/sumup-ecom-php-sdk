<?php

namespace SumUp\Application;

/**
 * Class Application
 *
 * @package SumUp\Application
 */
class Application
{
    /**
     * The default scopes that are recommended to be requested every time.
     *
     * @var array
     */
    private $defaultScopes = ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'];

    /**
     * The client ID.
     *
     * @var string
     */
    protected $clientId;

    /**
     * The client secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * The scopes that are needed for all services the application uses.
     *
     * @var array
     */
    protected $scopes;

    /**
     * Create a new application entity.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param array  $scopes
     */
    public function __construct($clientId, $clientSecret, $scopes)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setScopes($scopes);
    }

    /**
     * Returns the client ID.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Returns the client secret.
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Returns the scopes formatted as they should appear in the request.
     *
     * @return string
     */
    public function getScopes()
    {
        return implode(' ', $this->scopes);
    }

    /**
     * Set the scopes and always include the default ones
     *
     * @param array $scopes
     */
    private function setScopes(array $scopes = [])
    {
        $this->scopes = array_unique( array_merge($this->defaultScopes, $scopes), SORT_REGULAR);;
    }
}
