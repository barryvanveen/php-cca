<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
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

    /**
     * @test
     */
    public function itPrintsTheCurrentGrid()
    {
        $config = new Config;
        $config->rows(5);
        $config->columns(5);
        $config->states(3);

        $grid = $this->getGridStubForToArray($config);

        $cca = new CCA($config, $grid);

        $this->expectOutputString("Cells at generation 0:
  0 1 2 3 4 
0 1000 1001 1002 1003 1004 
1 1005 1006 1007 1008 1009 
2 1010 1011 1012 1013 1014 
3 1015 1016 1017 1018 1019 
4 1020 1021 1022 1023 1024 

");

        $cca->printCells();
    }

    protected function getGridStubForToArray(Config $config)
    {
        $cells = [];
        $neighbors = [];

        for ($row = 0; $row < $config->rows(); $row++) {
            for ($column = 0; $column < $config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $config->columns());

                $cell = $this->createMock(Cell::class);

                $cell->expects($this->once())
                    ->method('__toString')
                    ->will($this->returnValue(1000 + $coordinate->position()));

                $cells[$coordinate->position()] = $cell;

                $neighbors[$coordinate->position()] = [];
            }
        }

        return new Grid($config, $cells, $neighbors);
    }
}
