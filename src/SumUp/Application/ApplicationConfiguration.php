<?php

namespace SumUp\Application;

use SumUp\Exceptions\SumUpConfigurationException;

/**
 * Class ApplicationConfiguration
 *
 * @package SumUp\ApplicationConfiguration
 */
class ApplicationConfiguration
{
    /**
     * The default scopes that are recommended to be requested every time.
     *
     * @var array
     */
    protected $defaultScopes = ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly'];

    /**
     * The client ID.
     *
     * @var string
     */
    protected $appId;

    /**
     * The client secret.
     *
     * @var string
     */
    protected $appSecret;

    /**
     * The scopes that are needed for all services the application uses.
     *
     * @var array
     */
    protected $scopes;

    /**
     * The base URL of the SumUp API.
     *
     * @var string;
     */
    protected $baseURL;

    /**
     * The merchant's username. Needed only if the authorization flow is "password".
     *
     * @var string;
     */
    protected $username;

    /**
     * The merchant's account password. Needed only if the authorization flow is "password".
     *
     * @var string;
     */
    protected $password;

    /**
     * The authorization grant type.
     *
     * @var 'authorization_code'|'client_credentials'|'password';
     */
    protected $grantType;

    /**
     * The authorization code.
     *
     * @var string;
     */
    protected $code;

    /**
     * Create a new application configuration.
     *
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'app_id' => null,
            'app_secret' => null,
            'grant_type' => 'authorization_code',
            'base_uri' => 'https://api.sumup.com',
            'scopes' => [],
            'code' => null,
            'username' => null,
            'password' => null
        ], $config);

        $this->setAppId($config['app_id']);
        $this->setAppSecret($config['app_secret']);
        $this->setScopes($config['scopes']);
        $this->setGrantType($config['grant_type']);
        $this->baseURL = $config['base_uri'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->code = $config['code'];
    }

    /**
     * Returns the client ID.
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Returns the client secret.
     *
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
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
     * Returns the base URL of the SumUp API.
     *
     * @return string
     */
    public function getBaseURL()
    {
        return $this->baseURL;
    }

    /**
     * Returns authorization code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns grant type.
     *
     * @return string;
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * Returns merchant's username;
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Returns merchant's passowrd;
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set application ID.
     *
     * @param $appId
     * @throws \Exception
     */
    protected function setAppId($appId)
    {
        if(!isset($appId)) {
            throw new SumUpConfigurationException('Missing mandatory parameter app_id');
        }
        $this->appId = $appId;
    }

    /**
     * Set application secret.
     *
     * @param $appSecret
     * @throws \Exception
     */
    protected function setAppSecret($appSecret)
    {
        if(!isset($appSecret)) {
            throw new SumUpConfigurationException('Missing mandatory parameter app_secret');
        }
        $this->appSecret = $appSecret;
    }

    /**
     * Set the authorization grant type.
     *
     * @param $grantType
     * @throws \Exception
     */
    protected function setGrantType($grantType)
    {
        if(!in_array($grantType, ['authorization_code', 'client_credentials', 'password'])) {
            throw new \Exception('Invalid parameter for grant_type. \
            Allowed values are: \'authorization_code\'|\'client_credentials\'|\'password\'');
        }
        $this->grantType = $grantType;
    }

    /**
     * Set the scopes and always include the default ones
     *
     * @param array $scopes
     */
    protected function setScopes(array $scopes = [])
    {
        $this->scopes = array_unique(array_merge($this->defaultScopes, $scopes), SORT_REGULAR);;
    }
}
