<?php

namespace Barryvanveen\CCA\Tests;

use Barryvanveen\CCA\Config;
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
    public function it_returns_the_default_values()
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
    public function it_sets_the_rows()
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
    public function it_sets_the_columns()
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
    public function it_sets_the_states()
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
    public function it_sets_the_threshold()
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
    public function it_sets_the_neighborhood_type()
    {
        $config = new Config();

        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);

        $this->assertSame(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());

        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);

        $this->assertSame(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN, $config->neighborhoodType());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::neighborhoodType()
     */
    public function it_throws_an_exception_if_given_an_invalid_neighborhood_type()
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
    public function it_sets_the_neighborhood_size()
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
    public function it_sets_the_seed()
    {
        $config = new Config();

        $config->seed(1);

        $this->assertEquals(1, $config->seed());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::image_cell_size()
     */
    public function it_sets_the_cellsize()
    {
        $config = new Config();

        $config->image_cell_size(2);

        $this->assertEquals(2, $config->image_cell_size());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::toArray()
     */
    public function it_returns_an_array_containing_the_configuration()
    {
        $config = new Config();

        $config->rows(123);
        $config->neighborhoodType(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);

        $output = $config->toArray();

        $this->assertArrayHasKey(Config\Options::ROWS, $output);
        $this->assertEquals(123, $output[Config\Options::ROWS]);

        $this->assertArrayHasKey(Config\Options::NEIGHBORHOOD_TYPE, $output);
        $this->assertEquals(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $output[Config\Options::NEIGHBORHOOD_TYPE]);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::createFromPreset()
     */
    public function it_creates_a_preset_configuration()
    {
        $config = Config::createFromPreset(Presets::PRESET_313);

        $this->assertInstanceOf(Config::class, $config);

        $this->assertEquals(Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());
        $this->assertEquals(1, $config->neighborhoodSize());
        $this->assertEquals(3, $config->states());
        $this->assertEquals(3, $config->threshold());
    }
}
