<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\Config\NeighborhoodOptions;
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
        $builder = new ConfigBuilder();

        $config = $builder->get();

        $neighborhood = new Neighborhood(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertInternalType('array', $neighborhood->getNeighbors());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectMooreNeighborhoodOfSize1()
    {
        $builder = new ConfigBuilder();
        $builder->rows(10);
        $builder->columns(10);
        $builder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $builder->neighborhoodSize(1);

        $config = $builder->get();

        $neighborhood = new Neighborhood(
            $config,
            new Coordinate(0, 0, $config->columns())
        );
        $neighbors = $neighborhood->getNeighbors();

        $this->assertCount(8, $neighbors);

        $this->assertEquals("9, 9", $neighbors[0]->__toString());
        $this->assertEquals("9, 0", $neighbors[1]->__toString());
        $this->assertEquals("9, 1", $neighbors[2]->__toString());
        $this->assertEquals("0, 9", $neighbors[3]->__toString());
        $this->assertEquals("0, 1", $neighbors[4]->__toString());
        $this->assertEquals("1, 9", $neighbors[5]->__toString());
        $this->assertEquals("1, 0", $neighbors[6]->__toString());
        $this->assertEquals("1, 1", $neighbors[7]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectMooreNeighborhoodOfSize2()
    {
        $builder = new ConfigBuilder();
        $builder->rows(10);
        $builder->columns(10);
        $builder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $builder->neighborhoodSize(2);

        $config = $builder->get();

        $neighborhood = new Neighborhood(
            $config,
            new Coordinate(0, 0, $config->columns())
        );
        $neighbors = $neighborhood->getNeighbors();

        $this->assertCount(24, $neighbors);

        $this->assertEquals("8, 8", $neighbors[0]->__toString());
        $this->assertEquals("8, 9", $neighbors[1]->__toString());
        $this->assertEquals("8, 0", $neighbors[2]->__toString());
        $this->assertEquals("8, 1", $neighbors[3]->__toString());
        $this->assertEquals("8, 2", $neighbors[4]->__toString());
        $this->assertEquals("9, 8", $neighbors[5]->__toString());
        $this->assertEquals("9, 9", $neighbors[6]->__toString());
        $this->assertEquals("9, 0", $neighbors[7]->__toString());
        $this->assertEquals("9, 1", $neighbors[8]->__toString());
        $this->assertEquals("9, 2", $neighbors[9]->__toString());
        $this->assertEquals("0, 8", $neighbors[10]->__toString());
        $this->assertEquals("0, 9", $neighbors[11]->__toString());
        $this->assertEquals("0, 1", $neighbors[12]->__toString());
        $this->assertEquals("0, 2", $neighbors[13]->__toString());
        $this->assertEquals("1, 8", $neighbors[14]->__toString());
        $this->assertEquals("1, 9", $neighbors[15]->__toString());
        $this->assertEquals("1, 0", $neighbors[16]->__toString());
        $this->assertEquals("1, 1", $neighbors[17]->__toString());
        $this->assertEquals("1, 2", $neighbors[18]->__toString());
        $this->assertEquals("2, 8", $neighbors[19]->__toString());
        $this->assertEquals("2, 9", $neighbors[20]->__toString());
        $this->assertEquals("2, 0", $neighbors[21]->__toString());
        $this->assertEquals("2, 1", $neighbors[22]->__toString());
        $this->assertEquals("2, 2", $neighbors[23]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectMooreNeighborhoodOfSize3()
    {
        $builder = new ConfigBuilder();
        $builder->rows(10);
        $builder->columns(10);
        $builder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $builder->neighborhoodSize(3);

        $config = $builder->get();

        $neighborhood = new Neighborhood(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(48, $neighborhood->getNeighbors());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectNeumannNeighborhoodOfSize1()
    {
        $builder = new ConfigBuilder();
        $builder->rows(10);
        $builder->columns(10);
        $builder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);
        $builder->neighborhoodSize(1);

        $config = $builder->get();

        $neighborhood = new Neighborhood(
            $config,
            new Coordinate(0, 0, $config->columns())
        );
        $neighbors = $neighborhood->getNeighbors();

        $this->assertCount(4, $neighbors);

        $this->assertEquals("9, 0", $neighbors[0]->__toString());
        $this->assertEquals("0, 9", $neighbors[1]->__toString());
        $this->assertEquals("0, 1", $neighbors[2]->__toString());
        $this->assertEquals("1, 0", $neighbors[3]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectNeumannNeighborhoodOfSize2()
    {
        $builder = new ConfigBuilder();
        $builder->rows(10);
        $builder->columns(10);
        $builder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);
        $builder->neighborhoodSize(2);

        $config = $builder->get();

        $neighborhood = new Neighborhood(
            $config,
            new Coordinate(0, 0, $config->columns())
        );
        $neighbors = $neighborhood->getNeighbors();

        $this->assertCount(12, $neighbors);

        $this->assertEquals("8, 0", $neighbors[0]->__toString());
        $this->assertEquals("9, 9", $neighbors[1]->__toString());
        $this->assertEquals("9, 0", $neighbors[2]->__toString());
        $this->assertEquals("9, 1", $neighbors[3]->__toString());
        $this->assertEquals("0, 8", $neighbors[4]->__toString());
        $this->assertEquals("0, 9", $neighbors[5]->__toString());
        $this->assertEquals("0, 1", $neighbors[6]->__toString());
        $this->assertEquals("0, 2", $neighbors[7]->__toString());
        $this->assertEquals("1, 9", $neighbors[8]->__toString());
        $this->assertEquals("1, 0", $neighbors[9]->__toString());
        $this->assertEquals("1, 1", $neighbors[10]->__toString());
        $this->assertEquals("2, 0", $neighbors[11]->__toString());
    }

    /**
     * @test
     */
    public function itReturnsTheCorrectNeumannNeighborhoodOfSize3()
    {
        $builder = new ConfigBuilder();
        $builder->rows(10);
        $builder->columns(10);
        $builder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);
        $builder->neighborhoodSize(3);

        $config = $builder->get();

        $neighborhood = new Neighborhood(
            $config,
            new Coordinate(0, 0, $config->columns())
        );

        $this->assertCount(24, $neighborhood->getNeighbors());
    }
}
