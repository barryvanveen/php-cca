<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\Grid;
use Barryvanveen\CCA\GridBuilder;
use PHPUnit\Framework\MockObject\MockObject;

class GridTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::__construct()
     */
    public function itConstructsTheGridUsingTheGridBuilder()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);

        /** @var GridBuilder|MockObject $gridBuilderStub */
        $gridBuilderStub = $this->createMock(GridBuilder::class);
        $gridBuilderStub->expects($this->once())->method('getCells')->will($this->returnValue([]));
        $gridBuilderStub->expects($this->once())->method('getNeighbors')->will($this->returnValue([]));

        new Grid($config, $gridBuilderStub);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::computeNextState()
     */
    public function itCallsComputeNextStateOnEachCell()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);

        /** @var GridBuilder|MockObject $gridBuilderStub */
        $gridBuilderStub = $this->getGridBuilderStubForComputeNextState($config);

        $grid = new Grid($config, $gridBuilderStub);

        $grid->computeNextState();
    }

    protected function getGridBuilderStubForComputeNextState(Config $config)
    {
        $stub = $this->createMock(GridBuilder::class);

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

        $stub->method('getCells')->willReturn($cells);
        $stub->method('getNeighbors')->willReturn($neighbors);

        return $stub;
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::getStatesForCoordinates()
     */
    public function itPassesNeighboringStatesForComputingNextState()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);

        /** @var GridBuilder|MockObject $gridBuilderStub */
        $gridBuilderStub = $this->getGridBuilderStubForGetStatesForCoordinates($config);

        $grid = new Grid($config, $gridBuilderStub);

        $grid->computeNextState();
    }

    protected function getGridBuilderStubForGetStatesForCoordinates(Config $config)
    {
        $stub = $this->createMock(GridBuilder::class);

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

        $stub->method('getCells')->willReturn($cells);
        $stub->method('getNeighbors')->willReturn($neighbors);

        return $stub;
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::setNextState()
     */
    public function itCallsSetNextStateOnEachCell()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);

        /** @var GridBuilder|MockObject $gridBuilderStub */
        $gridBuilderStub = $this->getGridBuilderStubForSetNextState($config);

        $grid = new Grid($config, $gridBuilderStub);

        $grid->setNextState();
    }

    protected function getGridBuilderStubForSetNextState(Config $config)
    {
        $stub = $this->createMock(GridBuilder::class);

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

        $stub->method('getCells')->willReturn($cells);
        $stub->method('getNeighbors')->willReturn($neighbors);

        return $stub;
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::toArray()
     */
    public function itCanBeConvertedToAnArrayOfStates()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);

        /** @var GridBuilder|MockObject $gridBuilderStub */
        $gridBuilderStub = $this->getGridBuilderStubForToArray($config);

        $grid = new Grid($config, $gridBuilderStub);

        $array = $grid->toArray();

        $this->assertCount(25, $array);
        $this->assertEquals(1000, $array[0]);
        $this->assertEquals(1024, $array[24]);
    }

    protected function getGridBuilderStubForToArray(Config $config)
    {
        $stub = $this->createMock(GridBuilder::class);

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

        $stub->method('getCells')->willReturn($cells);
        $stub->method('getNeighbors')->willReturn($neighbors);

        return $stub;
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Grid::__toString()
     */
    public function itCanBeConvertedToAString()
    {
        $config = new Config();
        $config->rows(5);
        $config->columns(5);

        /** @var GridBuilder|MockObject $gridBuilderStub */
        $gridBuilderStub = $this->getGridBuilderStubForToString($config);

        $grid = new Grid($config, $gridBuilderStub);

        $string = (string) $grid;

        $expected = "  0 1 2 3 4 
0 1000 1001 1002 1003 1004 
1 1005 1006 1007 1008 1009 
2 1010 1011 1012 1013 1014 
3 1015 1016 1017 1018 1019 
4 1020 1021 1022 1023 1024 

";

        $this->assertEquals($expected, $string);
    }

    protected function getGridBuilderStubForToString(Config $config)
    {
        $stub = $this->createMock(GridBuilder::class);

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

        $stub->method('getCells')->willReturn($cells);
        $stub->method('getNeighbors')->willReturn($neighbors);

        return $stub;
    }
}
