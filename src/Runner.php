<?php

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Exceptions\LoopNotFoundException;

class Runner
{
    /** @var Config */
    protected $config;

    protected $cca;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->cca = new CCA($this->config);
    }

    /**
     * Run the CCA and return the $numIterations-th state.
     *
     * @param int $numIterations
     *
     * @return State
     */
    public function getSingleState(int $numIterations): State
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
            $hash = hash('crc32', $state->__toString());

            $cycleEnd = false;
            if ($cycleStart = array_search($hash, $hashes)) {
                $cycleEnd = count($states)+1;
            }

            $states[] = $state;
            $hashes[] = $hash;

            if ($cycleEnd !== false) {
                $states = array_slice($states, $cycleStart, $cycleEnd);

                return $states;
            }

            $iteration = $this->cca->cycle();
        } while ($iteration < $maxIterations);

        throw new LoopNotFoundException();
    }
}
