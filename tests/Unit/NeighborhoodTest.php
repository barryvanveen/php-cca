<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\Neighborhood;

/**
 * @covers \Barryvanveen\CCA\Neighborhood
 */
class NeighborhoodTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function itReturnsAnArray()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(1);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertInternalType('array', $neighborhood);
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectMooreNeighborhoodOfSize1()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(1);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(8, $neighborhood);

        $this->assertEquals("9, 9", $neighborhood[0]->__toString());
        $this->assertEquals("9, 0", $neighborhood[1]->__toString());
        $this->assertEquals("9, 1", $neighborhood[2]->__toString());
        $this->assertEquals("0, 9", $neighborhood[3]->__toString());
        $this->assertEquals("0, 1", $neighborhood[4]->__toString());
        $this->assertEquals("1, 9", $neighborhood[5]->__toString());
        $this->assertEquals("1, 0", $neighborhood[6]->__toString());
        $this->assertEquals("1, 1", $neighborhood[7]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectMooreNeighborhoodOfSize2()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(2);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(24, $neighborhood);

        $this->assertEquals("8, 8", $neighborhood[0]->__toString());
        $this->assertEquals("8, 9", $neighborhood[1]->__toString());
        $this->assertEquals("8, 0", $neighborhood[2]->__toString());
        $this->assertEquals("8, 1", $neighborhood[3]->__toString());
        $this->assertEquals("8, 2", $neighborhood[4]->__toString());
        $this->assertEquals("9, 8", $neighborhood[5]->__toString());
        $this->assertEquals("9, 9", $neighborhood[6]->__toString());
        $this->assertEquals("9, 0", $neighborhood[7]->__toString());
        $this->assertEquals("9, 1", $neighborhood[8]->__toString());
        $this->assertEquals("9, 2", $neighborhood[9]->__toString());
        $this->assertEquals("0, 8", $neighborhood[10]->__toString());
        $this->assertEquals("0, 9", $neighborhood[11]->__toString());
        $this->assertEquals("0, 1", $neighborhood[12]->__toString());
        $this->assertEquals("0, 2", $neighborhood[13]->__toString());
        $this->assertEquals("1, 8", $neighborhood[14]->__toString());
        $this->assertEquals("1, 9", $neighborhood[15]->__toString());
        $this->assertEquals("1, 0", $neighborhood[16]->__toString());
        $this->assertEquals("1, 1", $neighborhood[17]->__toString());
        $this->assertEquals("1, 2", $neighborhood[18]->__toString());
        $this->assertEquals("2, 8", $neighborhood[19]->__toString());
        $this->assertEquals("2, 9", $neighborhood[20]->__toString());
        $this->assertEquals("2, 0", $neighborhood[21]->__toString());
        $this->assertEquals("2, 1", $neighborhood[22]->__toString());
        $this->assertEquals("2, 2", $neighborhood[23]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectMooreNeighborhoodOfSize3()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(3);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(48, $neighborhood);
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectNeumannNeighborhoodOfSize1()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);
        $config->neighborhoodSize(1);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(4, $neighborhood);

        $this->assertEquals("9, 0", $neighborhood[0]->__toString());
        $this->assertEquals("0, 9", $neighborhood[1]->__toString());
        $this->assertEquals("0, 1", $neighborhood[2]->__toString());
        $this->assertEquals("1, 0", $neighborhood[3]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectNeumannNeighborhoodOfSize2()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);
        $config->neighborhoodSize(2);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(12, $neighborhood);

        $this->assertEquals("8, 0", $neighborhood[0]->__toString());
        $this->assertEquals("9, 9", $neighborhood[1]->__toString());
        $this->assertEquals("9, 0", $neighborhood[2]->__toString());
        $this->assertEquals("9, 1", $neighborhood[3]->__toString());
        $this->assertEquals("0, 8", $neighborhood[4]->__toString());
        $this->assertEquals("0, 9", $neighborhood[5]->__toString());
        $this->assertEquals("0, 1", $neighborhood[6]->__toString());
        $this->assertEquals("0, 2", $neighborhood[7]->__toString());
        $this->assertEquals("1, 9", $neighborhood[8]->__toString());
        $this->assertEquals("1, 0", $neighborhood[9]->__toString());
        $this->assertEquals("1, 1", $neighborhood[10]->__toString());
        $this->assertEquals("2, 0", $neighborhood[11]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectNeumannNeighborhoodOfSize3()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);
        $config->neighborhoodSize(3);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(24, $neighborhood);
    }
}
