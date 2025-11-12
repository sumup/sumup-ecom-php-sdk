<?php

namespace SumUp\Tests;

use PHPUnit\Framework\TestCase;
use SumUp\Application\ApplicationConfiguration;
use SumUp\Exceptions\SumUpConfigurationException;

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
}
