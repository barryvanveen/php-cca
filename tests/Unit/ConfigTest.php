<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Exceptions\InvalidOptionException;
use Phim\Color\RgbColor;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::__construct()
     * @covers \Barryvanveen\CCA\Config::makeSeed()
     * @covers \Barryvanveen\CCA\Config::makeHue()
     */
    public function itReturnsTheDefaultValues()
    {
        $config = new Config([]);

        $this->assertEquals($config->rows(), 48);

        $this->assertInternalType("integer", $config->seed());
        $this->assertInternalType("integer", $config->imageHue());
        $this->assertTrue(($config->imageHue() >= 0 && $config->imageHue() <= 360));
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::__construct()
     * @covers \Barryvanveen\CCA\Config\Validator::validate()
     */
    public function itThrowsAnErrorUponSettingAnInvalidOption()
    {
        $this->expectException(InvalidOptionException::class);

        new Config([
            "nonExistingOption" => 123,
        ]);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::columns()
     */
    public function itReturnsTheColumns()
    {
        $config = new Config([
            Options::COLUMNS => 123,
        ]);

        $this->assertEquals(123, $config->columns());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::imageCellSize()
     */
    public function itReturnsTheImageCellSize()
    {
        $config = new Config([
            Options::IMAGE_CELL_SIZE => 123,
        ]);

        $this->assertEquals(123, $config->imageCellSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::imageColors()
     */
    public function itReturnsTheImageColors()
    {
        $config = new Config([
            Options::IMAGE_COLORS => [
                new RgbColor(255, 255, 255),
                new RgbColor(0, 0, 0),
            ],
        ]);

        $this->assertEquals([
            new RgbColor(255, 255, 255),
            new RgbColor(0, 0, 0),
        ], $config->imageColors());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::imageHue()
     */
    public function itReturnsTheImageHue()
    {
        $config = new Config([
            Options::IMAGE_HUE => 123,
        ]);

        $this->assertEquals(123, $config->imageHue());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::neighborhoodSize()
     */
    public function itReturnsTheNeighborhoodSize()
    {
        $config = new Config([
            Options::NEIGHBORHOOD_SIZE => 2,
        ]);

        $this->assertEquals(2, $config->neighborhoodSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::neighborhoodType()
     */
    public function itReturnsTheNeighborhoodType()
    {
        $config = new Config([
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
        ]);

        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::rows()
     */
    public function itReturnsTheRows()
    {
        $config = new Config([
            Options::ROWS => 101,
        ]);

        $this->assertEquals(101, $config->rows());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::seed()
     */
    public function itReturnsTheSeed()
    {
        $config = new Config([
            Options::SEED => 123456,
        ]);

        $this->assertEquals(123456, $config->seed());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::states()
     */
    public function itReturnsTheStates()
    {
        $config = new Config([
            Options::STATES => 3,
        ]);

        $this->assertEquals(3, $config->states());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::threshold()
     */
    public function itReturnsTheThreshold()
    {
        $config = new Config([
            Options::THRESHOLD => 2,
        ]);

        $this->assertEquals(2, $config->threshold());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::toArray()
     */
    public function itReturnsAnArrayContainingTheConfiguration()
    {
        $config = new Config([
            Options::ROWS => 123,
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
        ]);

        $output = $config->toArray();

        $this->assertArrayHasKey(Options::ROWS, $output);
        $this->assertEquals(123, $output[Options::ROWS]);

        $this->assertArrayHasKey(Options::NEIGHBORHOOD_TYPE, $output);
        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $output[Options::NEIGHBORHOOD_TYPE]);
    }
}
