<?php

namespace Barryvanveen\CCA;

class State
{
    /** @var Config */
    protected $config;

    /** @var Grid */
    protected $grid;
    
    public function __construct(Config $config, Grid $grid)
    {
        $this->config = $config;
        $this->grid = $grid;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getGrid(): Grid
    {
        return $this->grid;
    }

    public function __toString()
    {
        return json_encode([
            'config' => $this->config->toArray(),
            'grid' => $this->grid->toArray(),
        ]);
    }
}
