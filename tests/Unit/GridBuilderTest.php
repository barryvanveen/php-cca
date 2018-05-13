<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Cell;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\GridBuilder;
use PHPUnit\Framework\MockObject\MockObject;

class GridBuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\GridBuilder::__construct()
     * @covers \Barryvanveen\CCA\GridBuilder::setSeed()
     */
    public function itSeedsTheRandomNumbersOnConstruct()
    {
        /** @var Config|MockObject $configMock */
        $configMock = $this->getMockBuilder(Config::class)
            ->setMethods(['seed'])
            ->getMock();

        $configMock->expects($this->once())
            ->method('seed');

        $configMock->rows(5);
        $configMock->columns(5);
        $configMock->states(3);

        new GridBuilder($configMock);
    }

    /**
     * @test
     */
    public function itReturnsDifferentStatesForDifferentSeeds()
    {
        $config = new Config;
        $config->rows(5);
        $config->columns(5);
        $config->states(3);
        $config->seed(123);

        $gridBuilder1 = new GridBuilder($config);
        $cells1 = $gridBuilder1->getCells();

        $config->seed(321);
        $gridBuilder2 = new GridBuilder($config);
        $cells2 = $gridBuilder2->getCells();

        $this->assertNotEquals($cells1, $cells2);
    }

    /**
     * @test
     */
    public function itReturnsEqualStatesForEqualSeeds()
    {
        $config = new Config;
        $config->rows(5);
        $config->columns(5);
        $config->states(3);
        $config->seed(123456);

        $gridBuilder1 = new GridBuilder($config);
        $cells1 = $gridBuilder1->getCells();

        $gridBuilder2 = new GridBuilder($config);
        $cells2 = $gridBuilder2->getCells();

        $this->assertEquals($cells1, $cells2);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\GridBuilder::getCells()
     */
    public function itReturnsAnArrayOfCells()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);

        $gridBuilder = new GridBuilder($config);

        $cells = $gridBuilder->getCells();

        $this->assertCount(100, $cells);
        $this->assertInstanceOf(Cell::class, $cells[0]);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\GridBuilder::getNeighbors()
     */
    public function itReturnsAnArrayOfNeighbors()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(1);

        $gridBuilder = new GridBuilder($config);

        $neighbors = $gridBuilder->getNeighbors();

        $this->assertCount(100, $neighbors);
        $this->assertInternalType("array", $neighbors[0]);
        $this->assertCount(8, $neighbors[0]);
        $this->assertInstanceOf(Coordinate::class, $neighbors[0][0]);
    }
}
