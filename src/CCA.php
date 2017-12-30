<?php

namespace Barryvanveen\CCA;

class CCA
{
    /** @var Config */
    protected $config;

    /** @var Grid */
    protected $grid;

    /** @var int */
    protected $generation;

    public function __construct(array $config = [])
    {
        $this->config = new Config($config);
    }

    public function init()
    {
        $this->grid = new Grid($this->config);
    }

    public function cycle($cycles = 1)
    {
        while ($cycles > 0) {
            $this->grid->computeNextState();

            $this->grid->setNextState();

            $this->generation++;

            $cycles--;
        }
    }

    public function printCells()
    {
        printf("Cells at generation %d:\n", $this->generation);

        printf("%s", $this->grid);
    }
}
