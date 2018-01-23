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
     * @covers \Barryvanveen\CCA\Config::rows()
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

        $this->assertEquals($config->rows(), 48);

        $config->rows(123);

        $this->assertEquals($config->rows(), 123);
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

        $this->assertEquals($config->neighborhoodType(), Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        $this->assertEquals($config->neighborhoodSize(), 1);
        $this->assertEquals($config->states(), 3);
        $this->assertEquals($config->threshold(), 3);
    }
}
