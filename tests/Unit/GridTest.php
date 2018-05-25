<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\Grid;
use PHPUnit\Framework\MockObject\MockObject;

class GridTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::computeNextState()
     */
    public function itCallsComputeNextStateOnEachCell()
    {
        $builder = new ConfigBuilder();
        $builder->rows(2);
        $builder->columns(2);

        $config = $builder->get();

        /** @var Grid|MockObject $gridStub */
        $gridStub = $this->getGridStubForComputeNextState($config);

        $gridStub->computeNextState();
    }

    protected function getGridStubForComputeNextState(Config $config)
    {
        $cells = [];
        $neighbors = [];

        for ($row = 0; $row < $config->rows(); $row++) {
            for ($column = 0; $column < $config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $config->columns());

                $cell = $this->createMock(Cell::class);

                $cell->expects($this->once())
                    ->method('computeNextState')
                    ->with([]);

                $cells[$coordinate->position()] = $cell;

                $neighbors[$coordinate->position()] = [];
            }
        }

        return new Grid($config, $cells, $neighbors);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::getStatesForCoordinates()
     */
    public function itPassesNeighboringStatesForComputingNextState()
    {
        $builder = new ConfigBuilder();
        $builder->rows(2);
        $builder->columns(2);

        $config = $builder->get();

        /** @var Grid|MockObject $gridStub */
        $gridStub = $this->getGridStubForGetStatesForCoordinates($config);

        $gridStub->computeNextState();
    }

    protected function getGridStubForGetStatesForCoordinates(Config $config)
    {
        $cells = [];
        $neighbors = [];

        for ($row = 0; $row < $config->rows(); $row++) {
            for ($column = 0; $column < $config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $config->columns());

                $cell = $this->createMock(Cell::class);

                $cells[$coordinate->position()] = $cell;

                $neighbors[$coordinate->position()] = [];
            }
        }

        // set neighbors for cell 0
        $neighbors[0] = [
            new Coordinate(0, 1, 5), // cell 1
            new Coordinate(0, 2, 5), // cell 2
            new Coordinate(0, 3, 5), // cell 3
        ];

        // set values for cell 1, 2, 3
        $cells[1]->expects($this->once())->method('getState')->will($this->returnValue(123));
        $cells[2]->expects($this->once())->method('getState')->will($this->returnValue(234));
        $cells[3]->expects($this->once())->method('getState')->will($this->returnValue(345));

        // set expection for cell 0
        $cells[0]->expects($this->once())->method('computeNextState')->with([123, 234, 345]);

        return new Grid($config, $cells, $neighbors);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::setNextState()
     */
    public function itCallsSetNextStateOnEachCell()
    {
        $builder = new ConfigBuilder();
        $builder->rows(2);
        $builder->columns(2);

        $config = $builder->get();

        /** @var Grid|MockObject $gridStub */
        $gridStub = $this->getGridStubForSetNextState($config);

        $gridStub->setNextState();
    }

    protected function getGridStubForSetNextState(Config $config)
    {
        $cells = [];
        $neighbors = [];

        for ($row = 0; $row < $config->rows(); $row++) {
            for ($column = 0; $column < $config->columns(); $column++) {
                $coordinate = new Coordinate($row, $column, $config->columns());

                $cell = $this->createMock(Cell::class);

                $cell->expects($this->once())
                    ->method('setNextState');

                $cells[$coordinate->position()] = $cell;

                $neighbors[$coordinate->position()] = [];
            }
        }

        return new Grid($config, $cells, $neighbors);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::toArray()
     */
    public function itCanBeConvertedToAnArrayOfStates()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);

        $config = $builder->get();

        /** @var Grid|MockObject $gridStub */
        $gridStub = $this->getGridStubForToArray($config);

        $array = $gridStub->toArray();

        $this->assertCount(25, $array);
        $this->assertEquals(1000, $array[0]);
        $this->assertEquals(1024, $array[24]);
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
                    ->method('getState')
                    ->will($this->returnValue(1000 + $coordinate->position()));

                $cells[$coordinate->position()] = $cell;

                $neighbors[$coordinate->position()] = [];
            }
        }

        return new Grid($config, $cells, $neighbors);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::__construct()
     * @covers \Barryvanveen\CCA\Grid::__toString()
     */
    public function itCanBeConvertedToAString()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);

        $config = $builder->get();

        /** @var Grid|MockObject $gridStub */
        $gridStub = $this->getGridStubForToString($config);

        $string = (string) $gridStub;

        $expected = "  0 1 2 3 4 
0 1000 1001 1002 1003 1004 
1 1005 1006 1007 1008 1009 
2 1010 1011 1012 1013 1014 
3 1015 1016 1017 1018 1019 
4 1020 1021 1022 1023 1024 

";

        $this->assertEquals($expected, $string);
    }

    protected function getGridStubForToString(Config $config)
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
