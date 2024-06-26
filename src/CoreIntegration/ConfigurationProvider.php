<?php

declare(strict_types=1);

namespace App\CoreIntegration;

use Leaf\Core\Application\Common\ConfigurationProvider as CoreConfigurationProvider;
use Leaf\Core\Application\Common\Exception\ConfigurationNotFoundException;
use Leaf\Core\Core\Configuration\Configuration;
use Throwable;

readonly class ConfigurationProvider implements CoreConfigurationProvider
{
    public function __construct(private string $configPath)
    {
    }

    public function find(string $identifier): Configuration
    {
        try {
            $config = require $this->configPath . $identifier . '.php';
        } catch (Throwable $_) {
            throw ConfigurationNotFoundException::create($identifier);
        }

        return new Configuration(
            $identifier,
            ...$config['fields']
        );
    }
}