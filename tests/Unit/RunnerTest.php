<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Exceptions\LoopNotFoundException;
use Barryvanveen\CCA\Runner;
use PHPUnit\Framework\MockObject\MockObject;

class RunnerTest extends \PHPUnit\Framework\TestCase
{
    use MockHelper;

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Runner::__construct()
     * @covers \Barryvanveen\CCA\Runner::getLastState()
     */
    public function itReturnsTheLastState()
    {
        /** @var CCA|MockObject $mockCCA */
        list($mockCCA, $config, $state1, $state2, $state3) = $this->getCCAMockWithNormalStates();

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
        /** @var CCA|MockObject $mockCCA */
        list($mockCCA, $config, $state1, $state2, $state3) = $this->getCCAMockWithNormalStates();

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
        /** @var CCA|MockObject $mockCCA */
        list($mockCCA, $config, $state1, $state2, $state3) = $this->getCCAMockWithLoopingStates();

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
        /** @var CCA|MockObject $mockCCA */
        list($mockCCA, $config, $state1, $state2, $state3) = $this->getCCAMockWithNormalStates();

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

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Runner::getFirstLoop()
     * @covers \Barryvanveen\CCA\Runner::loopIsFound()
     * @covers \Barryvanveen\CCA\Runner::loopIsTooShort()
     */
    public function itFindsALoopThatIsTooShortAndThrowsAnException()
    {
        /** @var CCA|MockObject $mockCCA */
        list($mockCCA, $config, $state1, $state2, $state3) = $this->getCCAMockWithEqualStates();

        $runner = new Runner($config, $mockCCA);

        $this->expectException(LoopNotFoundException::class);

        $runner->getFirstLoop(3);
    }
}
