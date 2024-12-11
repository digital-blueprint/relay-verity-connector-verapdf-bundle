<?php

namespace Dbp\Relay\VerityConnectorVerapdfBundle\Service;

class ConfigurationService
{
    private $config;

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
