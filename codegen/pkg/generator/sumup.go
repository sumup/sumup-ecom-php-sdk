package generator

import (
	"bytes"
	"fmt"
	"maps"
	"os"
	"path/filepath"
	"slices"
	"strings"

	"github.com/iancoleman/strcase"
)

var reservedServiceNames = map[string]struct{}{
	"Authorization": {},
	"Custom":        {},
}

var serviceMethodNameOverrides = map[string]string{
	"Checkouts":    "getCheckoutService",
	"Customers":    "getCustomerService",
	"Transactions": "getTransactionService",
	"Payouts":      "getPayoutService",
}

func (g *Generator) writeSumUpClass() error {
	dir := filepath.Join(g.cfg.Out, "SumUp")
	if err := os.MkdirAll(dir, os.ModePerm); err != nil {
		return fmt.Errorf("create SumUp directory: %w", err)
	}

	filename := filepath.Join(dir, "SumUp.php")
	f, err := os.OpenFile(filename, os.O_CREATE|os.O_WRONLY|os.O_TRUNC, 0o644)
	if err != nil {
		return fmt.Errorf("open %q: %w", filename, err)
	}
	defer func() {
		_ = f.Close()
	}()

	services := g.collectServiceDefinitions()

	var buf bytes.Buffer
	buf.WriteString(`<?php

namespace SumUp;

`)

	for _, useStmt := range sumUpUseStatements(services) {
		fmt.Fprintf(&buf, "use %s;\n", useStmt)
	}

	buf.WriteString("\n")
	buf.WriteString(`/**
 * Class SumUp
 *
 * @package SumUp
 */
class SumUp
{
    /**
     * The application's configuration.
     *
     * @var ApplicationConfiguration
     */
    protected $appConfig;

    /**
     * The access token that holds the data from the response.
     *
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @var SumUpHttpClientInterface
     */
    protected $client;

    /**
     * SumUp constructor.
     *
     * @param array $config
     * @param SumUpHttpClientInterface|null $customHttpClient
     *
     * @throws SumUpSDKException
     */
    public function __construct(array $config = [], SumUpHttpClientInterface $customHttpClient = null)
    {
        $this->appConfig = new ApplicationConfiguration($config);
        $this->client = HttpClientsFactory::createHttpClient($this->appConfig, $customHttpClient);
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->getToken();
    }

    /**
     * Returns the access token.
     *
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Refresh the access token.
     *
     * @param string $refreshToken
     *
     * @return AccessToken
     *
     * @throws SumUpSDKException
     */
    public function refreshToken($refreshToken = null)
    {
        if (isset($refreshToken)) {
            $rToken = $refreshToken;
        } elseif (!isset($refreshToken) && !isset($this->accessToken)) {
            throw new SumUpConfigurationException('There is no refresh token');
        } else {
            $rToken = $this->accessToken->getRefreshToken();
        }
        $authorizationService = new Authorization($this->client, $this->appConfig);
        $this->accessToken = $authorizationService->refreshToken($rToken);
        return $this->accessToken;
    }

    /**
     * Get the service for authorization.
     *
     * @param ApplicationConfigurationInterface|null $config
     *
     * @return Authorization
     */
    public function getAuthorizationService(ApplicationConfigurationInterface $config = null)
    {
        if (empty($config)) {
            $cfg = $this->appConfig;
        } else {
            $cfg = $config;
        }
        return new Authorization($this->client, $cfg);
    }

    /**
     * Resolve the access token that should be used for a service.
     *
     * @param AccessToken|null $accessToken
     *
     * @return AccessToken
     */
    protected function resolveAccessToken(AccessToken $accessToken = null)
    {
        if (!empty($accessToken)) {
            return $accessToken;
        }

        return $this->accessToken;
    }

`)

	for idx, service := range services {
		buf.WriteString(renderSumUpServiceMethod(service))
		if idx < len(services)-1 {
			buf.WriteString("\n")
		}
	}

	if len(services) > 0 {
		buf.WriteString("\n")
	}

	buf.WriteString(`    /**
     * @param AccessToken|null $accessToken
     *
     * @return Custom
     */
    public function getCustomService(AccessToken $accessToken = null)
    {
        $token = $this->resolveAccessToken($accessToken);

        return new Custom($this->client, $token);
    }
}
`)

	if _, err := f.Write(buf.Bytes()); err != nil {
		return fmt.Errorf("write SumUp file %q: %w", filename, err)
	}

	return nil
}

func (g *Generator) collectServiceDefinitions() []string {
	if len(g.operationsByTag) == 0 {
		return nil
	}

	tagKeys := slices.Collect(maps.Keys(g.operationsByTag))
	slices.Sort(tagKeys)
	services := make([]string, 0, len(tagKeys))

	for _, tagKey := range tagKeys {
		if tagKey == sharedTagKey {
			continue
		}

		operations := g.operationsByTag[tagKey]
		if len(operations) == 0 {
			continue
		}

		className := g.displayTagName(tagKey)
		if _, reserved := reservedServiceNames[className]; reserved {
			continue
		}

		services = append(services, className)
	}

	return services
}

func sumUpUseStatements(serviceNames []string) []string {
	uses := []string{
		"SumUp\\Application\\ApplicationConfiguration",
		"SumUp\\Application\\ApplicationConfigurationInterface",
		"SumUp\\Authentication\\AccessToken",
		"SumUp\\Exceptions\\SumUpConfigurationException",
		"SumUp\\Exceptions\\SumUpSDKException",
		"SumUp\\HttpClients\\HttpClientsFactory",
		"SumUp\\HttpClients\\SumUpHttpClientInterface",
	}

	serviceSet := map[string]struct{}{
		"SumUp\\Services\\Authorization": {},
		"SumUp\\Services\\Custom":        {},
	}

	for _, name := range serviceNames {
		serviceSet[fmt.Sprintf("SumUp\\Services\\%s", name)] = struct{}{}
	}

	serviceUses := slices.Collect(maps.Keys(serviceSet))
	slices.Sort(serviceUses)

	return append(uses, serviceUses...)
}

func renderSumUpServiceMethod(className string) string {
	var buf strings.Builder
	methodName := serviceMethodName(className)
	description := strings.TrimSpace(strcase.ToDelimited(className, ' '))
	if description == "" {
		description = strings.ToLower(className)
	}

	buf.WriteString("    /**\n")
	fmt.Fprintf(&buf, "     * Get the service for %s.\n", description)
	buf.WriteString("     *\n")
	buf.WriteString("     * @param AccessToken|null $accessToken\n")
	buf.WriteString("     *\n")
	fmt.Fprintf(&buf, "     * @return %s\n", className)
	buf.WriteString("     */\n")
	fmt.Fprintf(&buf, "    public function %s(AccessToken $accessToken = null)\n    {\n", methodName)
	buf.WriteString("        $token = $this->resolveAccessToken($accessToken);\n\n")
	fmt.Fprintf(&buf, "        return new %s($this->client, $token);\n", className)
	buf.WriteString("    }\n")

	return buf.String()
}

func serviceMethodName(className string) string {
	if method, ok := serviceMethodNameOverrides[className]; ok {
		return method
	}
	return fmt.Sprintf("get%sService", className)
}
