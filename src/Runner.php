<?php

declare(strict_types=1);

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Exceptions\LoopNotFoundException;

class Runner
{
    /** @var Config */
    protected $config;

    /** @var CCA */
    protected $cca;

    public function __construct(Config $config, CCA $cca)
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

            $firstOccurence = array_search($hash, $hashes);
            if ($this->loopIsFound($firstOccurence)) {
                if ($this->loopIsTooShort($states, $firstOccurence)) {
                    throw new LoopNotFoundException();
                }

                return array_slice($states, (int) $firstOccurence);
            }

            $states[] = $state;
            $hashes[] = $hash;

            $iteration = $this->cca->cycle();
        } while ($iteration < $maxIterations);

        throw new LoopNotFoundException();
    }

    protected function loopIsFound($firstOccurence)
    {
        return $firstOccurence !== false;
    }

    protected function loopIsTooShort($states, $firstOccurence)
    {
        return ((count($states) - (int) $firstOccurence) === 1);
    }
}
