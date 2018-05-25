<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

class Cell
{
    /** @var Config */
    protected $config;

    /** @var int */
    protected $state;

    /** @var int */
    protected $nextState;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->state = $this->getRandomState();
    }

    protected function getRandomState(): int
    {
        return mt_rand(0, $this->config->states() - 1);
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function computeNextState(array $neighborStates)
    {
        $successorState = $this->getSuccessorState();
        $count = 0;

        foreach ($neighborStates as $neighborState) {
            if ($neighborState === $successorState) {
                $count++;
            }
        }

        $this->nextState = $this->willCycle($count) ? $successorState : $this->state;
    }

    protected function getSuccessorState(): int
    {
        return ($this->state + 1) % $this->config->states();
    }

    protected function willCycle(int $count): bool
    {
        return $count >= $this->config->threshold();
    }

    public function setNextState()
    {
        $this->state = $this->nextState;
    }

    public function __toString(): string
    {
        return sprintf("%d", $this->state);
    }
}
