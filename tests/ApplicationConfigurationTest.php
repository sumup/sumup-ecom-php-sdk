<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Application\ApplicationConfiguration;
use SumUp\Exceptions\SumUpConfigurationException;
use SumUp\SdkInfo;

class ApplicationConfigurationTest extends TestCase
{
    public function testCustomScopesAreMergedWithDefaults()
    {
        $config = new ApplicationConfiguration([
            'api_key' => 'test-api-key',
            'scopes' => ['transactions.history', 'custom.scope'],
        ]);

        $scopes = $config->getScopes();

        foreach (ApplicationConfiguration::DEFAULT_SCOPES as $scope) {
            $this->assertContains($scope, $scopes);
        }

        $this->assertContains('custom.scope', $scopes);
        $this->assertStringContainsString('custom.scope', $config->getFormattedScopes());
    }

    public function testInvalidGrantTypeThrowsException()
    {
        $this->expectException(SumUpConfigurationException::class);

        new ApplicationConfiguration([
            'api_key' => 'test-api-key',
            'grant_type' => 'invalid',
        ]);
    }

    public function testUserAgentHeaderIsAlwaysAdded()
    {
        $config = new ApplicationConfiguration([
            'api_key' => 'test-api-key',
        ]);

        $headers = $config->getCustomHeaders();

        $this->assertArrayHasKey(ApplicationConfiguration::USER_AGENT_HEADER, $headers);
        $this->assertSame(SdkInfo::getUserAgent(), $headers[ApplicationConfiguration::USER_AGENT_HEADER]);
    }

    public function testCustomUserAgentHeaderIsOverridden()
    {
        $config = new ApplicationConfiguration([
            'api_key' => 'test-api-key',
            'custom_headers' => [
                'User-Agent' => 'custom-agent',
                'X-Custom' => 'value',
            ],
        ]);

        $headers = $config->getCustomHeaders();

        $this->assertSame(SdkInfo::getUserAgent(), $headers[ApplicationConfiguration::USER_AGENT_HEADER]);
        $this->assertSame('value', $headers['X-Custom']);
    }
}
