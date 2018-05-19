<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Exceptions\LoopNotFoundException;
use Barryvanveen\CCA\Interfaces\ConfigInterface;

class Runner
{
    /** @var ConfigInterface */
    protected $config;

    /** @var CCA */
    protected $cca;

    public function __construct(ConfigInterface $config, CCA $cca)
    {
        $this->config = $config;

        $this->cca = $cca;
    }

    /**
     * Run the CCA and return the $numIterations-th state.
     *
     * @param int $numIterations
     *
     * @return State
     */
    public function getLastState(int $numIterations): State
    {
        do {
            $state = $this->cca->getState();

            $iteration = $this->cca->cycle();
        } while ($iteration < $numIterations);

        return $state;
    }

    /**
     * Run the CCA and return an array with first $numIterations states.
     *
     * @param int $numIterations
     *
     * @return State[]
     */
    public function getFirstStates(int $numIterations): array
    {
        $states = [];

        do {
            $states[] = $this->cca->getState();

            $iteration = $this->cca->cycle();
        } while ($iteration < $numIterations);

        return $states;
    }

    /**
     * Run the CCA and return the first looping states it encounters. If no loop is found within $maxIterations,
     * a LoopNotFoundException exception will be thrown.
     *
     * @param int $maxIterations
     *
     * @throws LoopNotFoundException
     *
     * @return State[]
     */
    public function getFirstLoop(int $maxIterations)
    {
        $states = [];
        $hashes = [];

        do {
            $state = $this->cca->getState();
            $hash = $state->toHash();

            $cycleEnd = false;
            $cycleStart = array_search($hash, $hashes);
            if ($cycleStart !== false) {
                $cycleEnd = count($states);
            }

            $states[] = $state;
            $hashes[] = $hash;

            if ($cycleEnd !== false) {
                $states = array_slice($states, (int) $cycleStart, $cycleEnd);

                return $states;
            }

            $iteration = $this->cca->cycle();
        } while ($iteration < $maxIterations);

        throw new LoopNotFoundException();
    }
}
