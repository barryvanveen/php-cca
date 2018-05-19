<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Generators;

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidColorsException;
use Barryvanveen\CCA\Generators\Colors;
use Barryvanveen\CCA\OldConfig;
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

        $config = OldConfig::createFromPreset(Presets::PRESET_313);
        $config->states(3);
        $config->imageColors([
            $color1,
            $color2,
            $color3,
        ]);

        $colors = Colors::getColors($config);

        $this->assertCount(3, $colors);
        $this->assertContains($color1, $colors);
    }

    /**
     * @test
     */
    public function itThrowsAnExceptionWhenTooFewColorsAreSpecified()
    {
        $config = OldConfig::createFromPreset(Presets::PRESET_313);
        $config->states(3);
        $config->imageColors([
            new RgbColor(0, 1, 2),
        ]);

        $this->expectException(InvalidColorsException::class);
        $this->expectExceptionMessage("Not enough colors specified.");

        Colors::getColors($config);
    }

    /**
     * @test
     */
    public function itReturnsColorsCreatedBasedOnTheHue()
    {
        $config = OldConfig::createFromPreset(Presets::PRESET_313);
        $config->states(3);

        $colors = Colors::getColors($config);

        $this->assertCount(3, $colors);
        $this->assertInstanceOf(RgbColor::class, $colors[0]);
    }
}
