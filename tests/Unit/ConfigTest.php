<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidColorException;
use Barryvanveen\CCA\Exceptions\InvalidHueException;
use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;
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
        $config = new Config();

        $this->assertEquals($config->rows(), 48);

        $this->assertInternalType("integer", $config->seed());
        $this->assertInternalType("integer", $config->imageHue());
        $this->assertTrue(($config->imageHue() >= 0 && $config->imageHue() <= 360));
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
     * @covers \Barryvanveen\CCA\Config::imageColors()
     * @covers \Barryvanveen\CCA\Config::colorsAreValid()
     */
    public function itSetsTheColors()
    {
        $config = new Config();

        $config->imageColors([
            new RgbColor(0, 0, 0),
            new RgbColor(255, 255, 255),
        ]);

        $this->assertCount(2, $config->imageColors());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::imageColors()
     * @covers \Barryvanveen\CCA\Config::colorsAreValid()
     */
    public function itThrowsAnErrorWhenNotSettingColorsWithAnArray()
    {
        $config = new Config();

        $this->expectException(InvalidColorException::class);
        $this->expectExceptionMessage("Colors must be passed as an array.");

        $config->imageColors(new RgbColor(0, 0, 0));
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::imageColors()
     * @covers \Barryvanveen\CCA\Config::colorsAreValid()
     */
    public function itTrowsAnErrorWhenSettingInvalidColors()
    {
        $config = new Config();

        $this->expectException(InvalidColorException::class);

        $config->imageColors([
            'red',
            'blue',
        ]);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Config::imageHue()
     * @covers \Barryvanveen\CCA\Config::isValidHue()
     */
    public function itSetsTheImageHue()
    {
        $config = new Config();

        $config->imageHue(123);

        $this->assertEquals(123, $config->imageHue());
    }

    /**
     * @test
     *
     * @dataProvider invalidHueProvider
     *
     * @covers \Barryvanveen\CCA\Config::imageHue()
     * @covers \Barryvanveen\CCA\Config::isValidHue()
     */
    public function itThrowsAnExceptionWhenSettingInvalidHue($hueValue)
    {
        $config = new Config();

        $this->expectException(InvalidHueException::class);

        $config->imageHue($hueValue);
    }

    public function invalidHueProvider()
    {
        return [
            [
                'foo',
            ],
            [
                -1,
            ],
            [
                361,
            ],
        ];
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
