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
    /** @var ConfigBuilder */
    protected $configBuilder;

    public function setUp()
    {
        $this->configBuilder = new ConfigBuilder();
    }

    protected function getConfig()
    {
        return $this->configBuilder->get();
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::__construct()
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::get()
     */
    public function itReturnsTheDefaultValues()
    {
        $config = $this->configBuilder->get();

        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals($config->rows(), 10);
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::createFromPreset()
     */
    public function itCreatesAPresetConfiguration()
    {
        $this->configBuilder = $this->configBuilder->createFromPreset(Presets::PRESET_313);

        $config = $this->configBuilder->get();

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
        $this->configBuilder->columns(123);

        $this->assertEquals(123, $this->getConfig()->columns());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::imageCellSize()
     */
    public function itSetsTheImageCellSize()
    {
        $this->configBuilder->imageCellSize(123);

        $this->assertEquals(123, $this->getConfig()->imageCellSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::imageColors()
     */
    public function itSetsTheImageColors()
    {
        $this->configBuilder->imageColors([
            new RgbColor(0, 123, 255),
            new RgbColor(255, 255, 255),
        ]);

        $this->assertEquals([
            new RgbColor(0, 123, 255),
            new RgbColor(255, 255, 255),
        ], $this->getConfig()->imageColors());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::imageHue()
     */
    public function itSetsTheImageHue()
    {
        $this->configBuilder->imageHue(321);

        $this->assertEquals(321, $this->getConfig()->imageHue());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::neighborhoodSize()
     */
    public function itSetsTheNeighborhoodSize()
    {
        $this->configBuilder->neighborhoodSize(2);

        $this->assertEquals(2, $this->getConfig()->neighborhoodSize());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::neighborhoodType()
     */
    public function itSetsTheNeighborhoodType()
    {
        $this->configBuilder->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);

        $this->assertEquals(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE, $this->getConfig()->neighborhoodType());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::rows()
     */
    public function itSetsTheRows()
    {
        $this->configBuilder->rows(101);

        $this->assertEquals(101, $this->getConfig()->rows());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::seed()
     */
    public function itSetsTheSeed()
    {
        $this->configBuilder->seed(456123);

        $this->assertEquals(456123, $this->getConfig()->seed());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::states()
     */
    public function itSetsTheStates()
    {
        $this->configBuilder->states(2);

        $this->assertEquals(2, $this->getConfig()->states());
    }

    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Builders\ConfigBuilder::threshold()
     */
    public function itSetsTheThreshold()
    {
        $this->configBuilder->threshold(1);

        $this->assertEquals(1, $this->getConfig()->threshold());
    }
}
