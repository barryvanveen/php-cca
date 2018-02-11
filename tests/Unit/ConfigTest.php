<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::__construct()
     * @covers \Barryvanveen\CCA\Config::makeSeed()
     */
    public function itReturnsTheDefaultValues()
    {
        $config = new Config();

        $this->assertEquals($config->rows(), 48);

        $this->assertInternalType("integer", $config->seed());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::rows()
     */
    public function itSetsTheRows()
    {
        $config = new Config();

        $config->rows(123);

        $this->assertEquals(123, $config->rows());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::columns()
     */
    public function itSetsTheColumns()
    {
        $config = new Config();

        $config->columns(123);

        $this->assertEquals(123, $config->columns());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::states()
     */
    public function itSetsTheStates()
    {
        $config = new Config();

        $config->states(123);

        $this->assertEquals(123, $config->states());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::threshold()
     */
    public function itSetsTheThreshold()
    {
        $config = new Config();

        $config->threshold(123);

        $this->assertEquals(123, $config->threshold());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::neighborhoodType()
     */
    public function itSetsTheNeighborhoodType()
    {
        $config = new Config();

        $config->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);

        $this->assertSame(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());

        $config->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);

        $this->assertSame(NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN, $config->neighborhoodType());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::neighborhoodType()
     */
    public function itThrowsAnExceptionIfGivenAnInvalidNeighborhoodType()
    {
        $config = new Config();

        $this->expectException(InvalidNeighborhoodTypeException::class);

        $config->neighborhoodType('not_a_valid_neighborhood_type');
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::neighborhoodSize()
     */
    public function itSetsTheNeighborhoodSize()
    {
        $config = new Config();

        $config->neighborhoodSize(123);

        $this->assertSame(123, $config->neighborhoodSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::seed()
     */
    public function itSetsTheSeed()
    {
        $config = new Config();

        $config->seed(1);

        $this->assertEquals(1, $config->seed());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::imageCellSize()
     */
    public function itSetsTheCellsize()
    {
        $config = new Config();

        $config->imageCellSize(2);

        $this->assertEquals(2, $config->imageCellSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::toArray()
     */
    public function itReturnsAnArrayContainingTheConfiguration()
    {
        $config = new Config();

        $config->rows(123);
        $config->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);

        $output = $config->toArray();

        $this->assertArrayHasKey(Options::ROWS, $output);
        $this->assertEquals(123, $output[Options::ROWS]);

        $this->assertArrayHasKey(Options::NEIGHBORHOOD_TYPE, $output);
        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $output[Options::NEIGHBORHOOD_TYPE]);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::createFromPreset()
     */
    public function itCreatesAPresetConfiguration()
    {
        $config = Config::createFromPreset(Presets::PRESET_313);

        $this->assertInstanceOf(Config::class, $config);

        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());
        $this->assertEquals(1, $config->neighborhoodSize());
        $this->assertEquals(3, $config->states());
        $this->assertEquals(3, $config->threshold());
    }
}
