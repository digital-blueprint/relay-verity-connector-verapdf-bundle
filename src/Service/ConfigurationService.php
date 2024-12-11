<?php

declare(strict_types=1);

namespace Dbp\Relay\VerityConnectorVerapdfBundle\Service;

class ConfigurationService
{
    private $config;

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
