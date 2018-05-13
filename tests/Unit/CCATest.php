<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Factories\GridFactory;
use Barryvanveen\CCA\Grid;
use Barryvanveen\CCA\State;
use PHPUnit\Framework\MockObject\MockObject;

class CCATest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\CCA::__construct()
     * @covers \Barryvanveen\CCA\CCA::cycle()
     */
    public function itStartsAtGeneration0()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);
        $config->states(3);

        $cca = new CCA($config, GridFactory::create($config));

        $generation = $cca->cycle(0);

        $this->assertEquals(0, $generation);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\CCA::cycle()
     */
    public function itCallsGridForOnceCycle()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);
        $config->states(3);

        /** @var Grid|MockObject $gridMock */
        $gridMock = $this->createMock(Grid::class);

        $gridMock->expects($this->once())
            ->method('computeNextState');

        $gridMock->expects($this->once())
            ->method('setNextState');

        $cca = new CCA($config, $gridMock);

        $generation = $cca->cycle(1);

        $this->assertEquals(1, $generation);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\CCA::cycle()
     */
    public function itCallsGridForMultipleCycles()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);
        $config->states(3);

        /** @var Grid|MockObject $gridMock */
        $gridMock = $this->createMock(Grid::class);

        $gridMock->expects($this->exactly(3))
            ->method('computeNextState');

        $gridMock->expects($this->exactly(3))
            ->method('setNextState');

        $cca = new CCA($config, $gridMock);

        $generation = $cca->cycle(3);

        $this->assertEquals(3, $generation);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\CCA::getState()
     */
    public function itReturnsTheStateOfTheGrid()
    {
        $config = new Config;
        $config->rows(5);
        $config->columns(5);
        $config->states(3);

        $cca = new CCA($config, GridFactory::create($config));

        $state = $cca->getState();

        $this->assertInstanceOf(State::class, $state);
    }
}
