<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Presets;
use Phim\Color\RgbColor;

class ConfigBuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::__construct()
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::get()
     */
    public function itReturnsTheDefaultValues()
    {
        $builder = new ConfigBuilder();

        $config = $builder->get();

        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals($config->rows(), 48);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::createFromPreset()
     */
    public function itCreatesAPresetConfiguration()
    {
        $builder = new ConfigBuilder();
        $config = $builder->createFromPreset(Presets::PRESET_313)->get();

        $this->assertInstanceOf(Config::class, $config);

        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());
        $this->assertEquals(1, $config->neighborhoodSize());
        $this->assertEquals(3, $config->states());
        $this->assertEquals(3, $config->threshold());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::columns()
     */
    public function itSetsTheColumns()
    {
        $builder = new ConfigBuilder();

        $builder->columns(123);

        $config = $builder->get();

        $this->assertEquals(123, $config->columns());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::imageCellSize()
     */
    public function itSetsTheImageCellSize()
    {
        $builder = new ConfigBuilder();

        $builder->imageCellSize(123);

        $config = $builder->get();

        $this->assertEquals(123, $config->imageCellSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::imageColors()
     */
    public function itSetsTheImageColors()
    {
        $builder = new ConfigBuilder();

        $builder->imageColors([
            new RgbColor(0, 123, 255),
            new RgbColor(255, 255, 255),
        ]);

        $config = $builder->get();

        $this->assertEquals([
            new RgbColor(0, 123, 255),
            new RgbColor(255, 255, 255),
        ], $config->imageColors());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::imageHue()
     */
    public function itSetsTheImageHue()
    {
        $builder = new ConfigBuilder();

        $builder->imageHue(321);

        $config = $builder->get();

        $this->assertEquals(321, $config->imageHue());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::neighborhoodSize()
     */
    public function itSetsTheNeighborhoodSize()
    {
        $builder = new ConfigBuilder();

        $builder->neighborhoodSize(2);

        $config = $builder->get();

        $this->assertEquals(2, $config->neighborhoodSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::neighborhoodType()
     */
    public function itSetsTheNeighborhoodType()
    {
        $builder = new ConfigBuilder();

        $builder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);

        $config = $builder->get();

        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $config->neighborhoodType());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::rows()
     */
    public function itSetsTheRows()
    {
        $builder = new ConfigBuilder();

        $builder->rows(101);

        $config = $builder->get();

        $this->assertEquals(101, $config->rows());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::seed()
     */
    public function itSetsTheSeed()
    {
        $builder = new ConfigBuilder();

        $builder->seed(456123);

        $config = $builder->get();

        $this->assertEquals(456123, $config->seed());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::states()
     */
    public function itSetsTheStates()
    {
        $builder = new ConfigBuilder();

        $builder->states(2);

        $config = $builder->get();

        $this->assertEquals(2, $config->states());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::threshold()
     */
    public function itSetsTheThreshold()
    {
        $builder = new ConfigBuilder();

        $builder->threshold(1);

        $config = $builder->get();

        $this->assertEquals(1, $config->threshold());
    }
}
