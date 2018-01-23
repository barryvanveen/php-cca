<?php

namespace Barryvanveen\PhpCca;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;

/**
 * @covers \Barryvanveen\CCA\Config
 */
class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function it_returns_the_default_values()
    {
        $config = new Config();

        $this->assertEquals($config->rows(), 48);

        $this->assertInternalType("integer", $config->seed());
    }

    /**
     * @test
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
     */
    public function it_throws_an_exception_if_given_an_invalid_neighborhood_type()
    {
        $config = new Config();

        $this->expectException(InvalidNeighborhoodTypeException::class);

        $config->neighborhoodType('not_a_valid_neighborhood_type');
    }

    /**
     * @test
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
}
