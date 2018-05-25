<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\Cell;

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
        $builder = new ConfigBuilder();
        $builder->states(3);

        $config = $builder->get();

        $cell = new Cell($config);

        $state = $cell->getState();

        $this->assertTrue(($state >= 0 && $state < 3), $state);
    }

    /**
     * @test
     */
    public function itDoesNotChangeStateIfThresholdIsNotMet()
    {
        $builder = new ConfigBuilder();
        $builder->states(3);
        $builder->threshold(1);

        $config = $builder->get();

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
        $builder = new ConfigBuilder();
        $builder->states(3);
        $builder->threshold(1);

        $config = $builder->get();

        $cell = new Cell($config);
        $currentState = $cell->getState();

        $nextState = $currentState + 1;
        if ($nextState === 3) {
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
        $builder = new ConfigBuilder();
        $builder->states(3);
        $builder->threshold(1);

        $config = $builder->get();

        $cell = new Cell($config);
        $currentState = $cell->getState();

        $this->assertEquals($currentState, $cell->__toString());
    }
}
