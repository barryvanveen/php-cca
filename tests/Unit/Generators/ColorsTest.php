<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Generators;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidColorsException;
use Barryvanveen\CCA\Generators\Colors;
use Phim\Color\RgbColor;

/**
 * @covers \Barryvanveen\CCA\Generators\Colors
 */
class ColorsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function itReturnsTheColorsFromConfig()
    {
        $color1 = new RgbColor(0, 1, 2);
        $color2 = new RgbColor(3, 4, 5);
        $color3 = new RgbColor(6, 7, 8);

        $builder = new ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_313);
        $builder->states(3);
        $builder->imageColors([
            $color1,
            $color2,
            $color3,
        ]);

        $config = $builder->get();

        $colors = Colors::getColors($config);

        $this->assertCount(3, $colors);
        $this->assertContains($color1, $colors);
    }

    /**
     * @test
     */
    public function itThrowsAnExceptionWhenTooFewColorsAreSpecified()
    {
        $builder = new ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_313);
        $builder->states(3);
        $builder->imageColors([
            new RgbColor(0, 1, 2),
        ]);

        $config = $builder->get();

        $this->expectException(InvalidColorsException::class);
        $this->expectExceptionMessage("Not enough colors specified.");

        Colors::getColors($config);
    }

    /**
     * @test
     */
    public function itReturnsColorsCreatedBasedOnTheHue()
    {
        $builder = new ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_313);
        $builder->states(3);

        $config = $builder->get();

        $colors = Colors::getColors($config);

        $this->assertCount(3, $colors);
        $this->assertInstanceOf(RgbColor::class, $colors[0]);
    }
}
