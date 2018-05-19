<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidColorException;
use Barryvanveen\CCA\Exceptions\InvalidHueException;
use Barryvanveen\CCA\Exceptions\InvalidNeighborhoodTypeException;
use Barryvanveen\CCA\OldConfig;
use Phim\Color\RgbColor;

class OldConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::__construct()
     * @covers \Barryvanveen\CCA\OldConfig::makeSeed()
     * @covers \Barryvanveen\CCA\OldConfig::makeHue()
     */
    public function itReturnsTheDefaultValues()
    {
        $config = new OldConfig();

        $this->assertEquals($config->rows(), 48);

        $this->assertInternalType("integer", $config->seed());
        $this->assertInternalType("integer", $config->imageHue());
        $this->assertTrue(($config->imageHue() >= 0 && $config->imageHue() <= 360));
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::rows()
     */
    public function itSetsTheRows()
    {
        $config = new OldConfig();

        $config->rows(123);

        $this->assertEquals(123, $config->rows());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::columns()
     */
    public function itSetsTheColumns()
    {
        $config = new OldConfig();

        $config->columns(123);

        $this->assertEquals(123, $config->columns());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::states()
     */
    public function itSetsTheStates()
    {
        $config = new OldConfig();

        $config->states(123);

        $this->assertEquals(123, $config->states());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::threshold()
     */
    public function itSetsTheThreshold()
    {
        $config = new OldConfig();

        $config->threshold(123);

        $this->assertEquals(123, $config->threshold());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::neighborhoodType()
     */
    public function itSetsTheNeighborhoodType()
    {
        $config = new OldConfig();

        $config->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);

        $this->assertSame(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());

        $config->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN);

        $this->assertSame(NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN, $config->neighborhoodType());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::neighborhoodType()
     */
    public function itThrowsAnExceptionIfGivenAnInvalidNeighborhoodType()
    {
        $config = new OldConfig();

        $this->expectException(InvalidNeighborhoodTypeException::class);

        $config->neighborhoodType('not_a_valid_neighborhood_type');
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::neighborhoodSize()
     */
    public function itSetsTheNeighborhoodSize()
    {
        $config = new OldConfig();

        $config->neighborhoodSize(123);

        $this->assertSame(123, $config->neighborhoodSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::seed()
     */
    public function itSetsTheSeed()
    {
        $config = new OldConfig();

        $config->seed(1);

        $this->assertEquals(1, $config->seed());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::imageCellSize()
     */
    public function itSetsTheCellsize()
    {
        $config = new OldConfig();

        $config->imageCellSize(2);

        $this->assertEquals(2, $config->imageCellSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::imageColors()
     * @covers \Barryvanveen\CCA\OldConfig::colorsAreValid()
     */
    public function itSetsTheColors()
    {
        $config = new OldConfig();

        $config->imageColors([
            new RgbColor(0, 0, 0),
            new RgbColor(255, 255, 255),
        ]);

        $this->assertCount(2, $config->imageColors());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::imageColors()
     * @covers \Barryvanveen\CCA\OldConfig::colorsAreValid()
     */
    public function itThrowsAnErrorWhenNotSettingColorsWithAnArray()
    {
        $config = new OldConfig();

        $this->expectException(InvalidColorException::class);
        $this->expectExceptionMessage("Colors must be passed as an array.");

        $config->imageColors(new RgbColor(0, 0, 0));
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::imageColors()
     * @covers \Barryvanveen\CCA\OldConfig::colorsAreValid()
     */
    public function itTrowsAnErrorWhenSettingInvalidColors()
    {
        $config = new OldConfig();

        $this->expectException(InvalidColorException::class);

        $config->imageColors([
            'red',
            'blue',
        ]);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\OldConfig::imageHue()
     * @covers \Barryvanveen\CCA\OldConfig::isValidHue()
     */
    public function itSetsTheImageHue()
    {
        $config = new OldConfig();

        $config->imageHue(123);

        $this->assertEquals(123, $config->imageHue());
    }

    /**
     * @test
     *
     * @dataProvider invalidHueProvider
     *
     * @covers \Barryvanveen\CCA\OldConfig::imageHue()
     * @covers \Barryvanveen\CCA\OldConfig::isValidHue()
     */
    public function itThrowsAnExceptionWhenSettingInvalidHue($hueValue)
    {
        $config = new OldConfig();

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
     * @covers \Barryvanveen\CCA\OldConfig::toArray()
     */
    public function itReturnsAnArrayContainingTheConfiguration()
    {
        $config = new OldConfig();

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
     * @covers \Barryvanveen\CCA\OldConfig::createFromPreset()
     */
    public function itCreatesAPresetConfiguration()
    {
        $config = OldConfig::createFromPreset(Presets::PRESET_313);

        $this->assertInstanceOf(OldConfig::class, $config);

        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());
        $this->assertEquals(1, $config->neighborhoodSize());
        $this->assertEquals(3, $config->states());
        $this->assertEquals(3, $config->threshold());
    }
}
