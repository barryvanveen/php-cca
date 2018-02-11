<?php

namespace Barryvanveen\CCA\Tests;

use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Config;

/**
 * @covers \Barryvanveen\CCA\Cell
 */
class CellTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function itSetsARandomState()
    {
        $config = new Config();
        $config->states(3);

        $cell = new Cell($config);

        $state = $cell->getState();

        $this->assertTrue(($state >= 0 && $state < 3), $state);
    }

    /**
     * @test
     */
    public function itDoesNotChangeStateIfThresholdIsNotMet()
    {
        $config = new Config();
        $config->states(3);
        $config->threshold(1);

        $cell = new Cell($config);
        $currentState = $cell->getState();

        $cell->computeNextState([]);
        $cell->setNextState();

        $this->assertEquals($currentState, $cell->getState());
    }

    /**
     * @test
     */
    public function itChangesStateIfThresholdIsMet()
    {
        $config = new Config();
        $config->states(3);
        $config->threshold(1);

        $cell = new Cell($config);
        $currentState = $cell->getState();

        $nextState = $currentState + 1;
        if ($nextState == 3) {
            $nextState = 0;
        }

        $cell->computeNextState([$nextState]);
        $cell->setNextState();

        $this->assertEquals($nextState, $cell->getState());
    }

    /**
     * @test
     */
    public function itOutputsToString()
    {
        $config = new Config();
        $config->states(3);
        $config->threshold(1);

        $cell = new Cell($config);
        $currentState = $cell->getState();

        $this->assertEquals($currentState, $cell->__toString());
    }
}
