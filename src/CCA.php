<?php

namespace Barryvanveen\CCA;

class CCA
{
    /** @var Config */
    protected $config;

    /** @var Grid */
    protected $grid;

    /** @var int */
    protected $generation = 0;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->setSeed();

        $this->grid = new Grid($this->config);
    }

    private function setSeed()
    {
        mt_srand($this->config->seed());
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
