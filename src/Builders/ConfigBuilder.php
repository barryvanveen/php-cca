<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Builders;

use Barryvanveen\CCA\Config;

class ConfigBuilder
{
    /** @var Config */
    protected $config;

    public function __construct()
    {
        $this->config = new Config();
    }
}
