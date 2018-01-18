<?php

namespace Barryvanveen\PhpCca;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Coordinate;
use Barryvanveen\CCA\Neighborhood;

class NeighborhoodTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Neighborhood::createNeighborhoodForCoordinate()
     */
    public function it_returns_an_array()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(1);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate($config, new Coordinate(0, 0, $config->columns()));

        $this->assertInternalType('array', $neighborhood);
    }

    /**
     * @test
     */
    public function it_returns_the_correct_moore_neighborhood_of_size_1()
    {
        $config = new Config();
        $config->rows(10);
        $config->columns(10);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(1);

        $neighborhood = Neighborhood::createNeighborhoodForCoordinate($config, new Coordinate(0, 0, $config->columns()));

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
}
