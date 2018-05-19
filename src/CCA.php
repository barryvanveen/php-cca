<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Interfaces\ConfigInterface;

class CCA
{
    /** @var ConfigInterface */
    protected $config;

    /** @var Grid */
    protected $grid;

    /** @var int */
    protected $generation = 0;

    public function __construct(ConfigInterface $config, Grid $grid)
    {
        $this->config = $config;

        $this->grid = $grid;
    }

    public function cycle(int $cycles = 1): int
    {
        while ($cycles > 0) {
            $this->grid->computeNextState();

            $this->grid->setNextState();

            $this->generation++;

            $cycles--;
        }

        return $this->generation;
    }

    public function getState(): State
    {
        return new State($this->grid);
    }

    public function printCells()
    {
        printf("Cells at generation %d:\n", $this->generation);

        printf("%s", $this->grid);
    }
}
