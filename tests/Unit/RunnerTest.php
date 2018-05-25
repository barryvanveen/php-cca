<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Exceptions\LoopNotFoundException;
use Barryvanveen\CCA\Factories\GridFactory;
use Barryvanveen\CCA\Runner;
use Barryvanveen\CCA\State;
use PHPUnit\Framework\MockObject\MockObject;

class RunnerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Runner::__construct()
     * @covers \Barryvanveen\CCA\Runner::getLastState()
     */
    public function itReturnsTheLastState()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);
        $builder->states(3);

        /** @var CCA|MockObject $mockCCA */
        $mockCCA = $this->createMock(CCA::class);

        $builder->seed(1);
        $config = $builder->get();
        $state1 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state2 = new State(GridFactory::create($config));

        $builder->seed(3);
        $config = $builder->get();
        $state3 = new State(GridFactory::create($config));

        $mockCCA->expects($this->exactly(3))
            ->method('getState')
            ->willReturnOnConsecutiveCalls(
                $state1,
                $state2,
                $state3
            );

        $mockCCA->expects($this->exactly(3))
            ->method('cycle')
            ->willReturnOnConsecutiveCalls(
                1,
                2,
                3
            );

        $runner = new Runner($config, $mockCCA);

        $lastState = $runner->getLastState(3);

        $this->assertEquals($lastState, $state3);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Runner::getFirstStates()
     */
    public function itReturnsTheFirstStates()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);
        $builder->states(3);

        /** @var CCA|MockObject $mockCCA */
        $mockCCA = $this->createMock(CCA::class);

        $builder->seed(1);
        $config = $builder->get();
        $state1 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state2 = new State(GridFactory::create($config));

        $builder->seed(3);
        $config = $builder->get();
        $state3 = new State(GridFactory::create($config));

        $mockCCA->expects($this->exactly(3))
            ->method('getState')
            ->willReturnOnConsecutiveCalls(
                $state1,
                $state2,
                $state3
            );

        $mockCCA->expects($this->exactly(3))
            ->method('cycle')
            ->willReturnOnConsecutiveCalls(
                1,
                2,
                3
            );

        $runner = new Runner($config, $mockCCA);

        $states = $runner->getFirstStates(3);

        $this->assertEquals($states, [$state1, $state2, $state3]);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Runner::getFirstLoop()
     */
    public function itReturnsTheFirstLoop()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);
        $builder->states(3);

        /** @var CCA|MockObject $mockCCA */
        $mockCCA = $this->createMock(CCA::class);

        // $state1 and $state3 are equal -> first loop should [$state1 $state2]

        $builder->seed(1);
        $config = $builder->get();
        $state1 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state2 = new State(GridFactory::create($config));

        $builder->seed(1);
        $config = $builder->get();
        $state3 = new State(GridFactory::create($config));

        $mockCCA->expects($this->exactly(3))
            ->method('getState')
            ->willReturnOnConsecutiveCalls(
                $state1,
                $state2,
                $state3
            );

        $mockCCA->expects($this->exactly(2))
            ->method('cycle')
            ->willReturnOnConsecutiveCalls(
                1,
                2,
                3
            );

        $runner = new Runner($config, $mockCCA);

        $expected = [];
        $expected[] = $state1;
        $expected[] = $state2;

        $states = $runner->getFirstLoop(3);

        $this->assertCount(2, $states);
        $this->assertEquals($states, $expected);
    }


    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Runner::getFirstLoop()
     */
    public function itFailsToFindALoopAndThrowsAnException()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);
        $builder->states(3);

        /** @var CCA|MockObject $mockCCA */
        $mockCCA = $this->createMock(CCA::class);

        $builder->seed(1);
        $config = $builder->get();
        $state1 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state2 = new State(GridFactory::create($config));

        $builder->seed(3);
        $config = $builder->get();
        $state3 = new State(GridFactory::create($config));

        $mockCCA->expects($this->exactly(3))
            ->method('getState')
            ->willReturnOnConsecutiveCalls(
                $state1,
                $state2,
                $state3
            );

        $mockCCA->expects($this->exactly(3))
            ->method('cycle')
            ->willReturnOnConsecutiveCalls(
                1,
                2,
                3
            );

        $runner = new Runner($config, $mockCCA);

        $this->expectException(LoopNotFoundException::class);

        $runner->getFirstLoop(3);
    }
}
