<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Builders;

use Barryvanveen\CCA\OldConfig;

class ConfigBuilder
{
    /** @var OldConfig */
    protected $config;

    public function __construct()
    {
        $this->config = new OldConfig();
    }
}
