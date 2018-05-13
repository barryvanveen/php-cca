<?php

namespace Barryvanveen\CCA\Factories;

use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Config;

class CCAFactory
{
    public static function create(Config $config)
    {
        return new CCA($config, GridFactory::create($config));
    }
}
