<?php

namespace Meow\Core\Tools;

class Configuration
{
    protected array $configuration;

    public function __construct()
    {
        $this->configuration = include(CONFIG . 'application.php');
    }

    /**
     * Undocumented function
     *
     * @param string $configurationName
     * @return array
     */
    public static function read(string $configurationName) : array
    {
        $configuration = new self();

        return $configuration->getConfiguration($configurationName);
    }

    /**
     * @param string $configurationName
     * @return array
     */
    public function getConfiguration(string $configurationName): array
    {
        return $this->configuration[$configurationName];
    }
}