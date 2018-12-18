<?php

use PHPUnit\Framework\TestCase;
use \SumUp\Application\ApplicationConfiguration;
use \SumUp\Exceptions\SumUpConfigurationException;

class ApplicationConfigurationTest extends TestCase
{
    public function testCreateApplicationWithMinimumConfiguration()
    {
        $appConf = new ApplicationConfiguration(['app_id' => 'application-id', 'app_secret' => 'application-secret']);

        $this->assertInstanceOf(
            ApplicationConfiguration::class,
            $appConf
        );
    }

    public function testThrowExceptionIfAppIdIsMissing()
    {
        $this->expectException(
            SumUpConfigurationException::class
        );

        new ApplicationConfiguration(['app_secret' => 'application-secret']);
    }

    public function testThrowExceptionIfAppSecretIsMissing()
    {
        $this->expectException(
            SumUpConfigurationException::class
        );

        new ApplicationConfiguration(['app_id' => 'application-id']);
    }

    public function testThrowExceptionIfWrongGrantTypeIsPassed()
    {
        $this->expectException(
            SumUpConfigurationException::class
        );

        new ApplicationConfiguration([
            'app_id' => 'application-id',
            'app_secret' => 'application-secret',
            'grant_type' => 'wrong-grant-type'
        ]);
    }

    public function testAllConfigurationsAreSet()
    {
        $appConf = new ApplicationConfiguration([
            'app_id' => 'application-id',
            'app_secret' => 'application-secret',
            'grant_type' => 'client_credentials',
            'scopes' => ['payments', 'transactions.history'],
            'code' => '1234567890',
            'default_access_token' => 'access-token',
            'default_refresh_token' => 'refresh-token',
            'username' => 'user',
            'password' => 'pass'
        ]);

        $this->assertSame($appConf->getAppId(), 'application-id');
        $this->assertSame($appConf->getAppSecret(), 'application-secret');
        $this->assertSame($appConf->getGrantType(), 'client_credentials');
        $this->assertSame($appConf->getScopes(), ['payments', 'transactions.history', 'user.app-settings', 'user.profile_readonly']);
        $this->assertSame($appConf->getCode(), '1234567890');
        $this->assertSame($appConf->getDefaultAccessToken(), 'access-token');
        $this->assertSame($appConf->getDefaultRefreshToken(), 'refresh-token');
        $this->assertSame($appConf->getUsername(), 'user');
        $this->assertSame($appConf->getPassword(), 'pass');
        $this->assertSame($appConf->getBaseURL(), 'https://api.sumup.com');
    }

    public function testFormattingOfScopes()
    {
        $appConf = new ApplicationConfiguration([
            'app_id' => 'application-id',
            'app_secret' => 'application-secret',
            'scopes' => ['payments', 'transactions.history'],
        ]);

        $this->assertSame($appConf->getFormattedScopes(), 'payments transactions.history user.app-settings user.profile_readonly');
    }
}
