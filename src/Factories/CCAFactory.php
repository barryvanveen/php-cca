<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Factories;

use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Interfaces\ConfigInterface;

class CCAFactory
{
    public static function create(ConfigInterface $config)
    {
        return new CCA($config, GridFactory::create($config));
    }
}
