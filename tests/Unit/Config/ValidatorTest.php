<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Config;

use Barryvanveen\CCA\Config\NeighborhoodOptions;
use Barryvanveen\CCA\Config\Options;
use Barryvanveen\CCA\Config\Validator;
use Barryvanveen\CCA\Exceptions\InvalidValueException;
use Phim\Color\RgbColor;

/**
 * @covers \Barryvanveen\CCA\Config\Validator
 */
class ValidatorTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     *
     * @dataProvider optionsThatAcceptPositiveIntegersProvider
     */
    public function itAcceptsPositiveIntegers($option)
    {
        $result = Validator::validate([
            $option => 10,
        ]);

        $this->assertEquals(true, $result);
    }

    public function optionsThatAcceptPositiveIntegersProvider()
    {
        return [
            [ Options::COLUMNS ],
            [ Options::IMAGE_CELL_SIZE ],
            [ Options::NEIGHBORHOOD_SIZE, ],
            [ Options::ROWS, ],
            [ Options::SEED, ],
            [ Options::STATES, ],
            [ Options::THRESHOLD, ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider optionsThatRejectNonIntegersProvider
     */
    public function itRejectsNonIntegers($option)
    {
        $this->expectException(InvalidValueException::class);

        Validator::validate([
            $option => "123",
        ]);
    }

    public function optionsThatRejectNonIntegersProvider()
    {
        return [
            [ Options::COLUMNS ],
            [ Options::IMAGE_CELL_SIZE ],
            [ Options::IMAGE_HUE ],
            [ Options::NEIGHBORHOOD_SIZE, ],
            [ Options::ROWS, ],
            [ Options::SEED, ],
            [ Options::STATES, ],
            [ Options::THRESHOLD, ],
        ];
    }

    /**
     * @test
     *
     * @dataProvider optionsThatRejectNegativeIntegersProvider
     */
    public function itRejectsNegativeIntegers($option)
    {
        $this->expectException(InvalidValueException::class);

        Validator::validate([
            $option => -1,
        ]);
    }

    public function optionsThatRejectNegativeIntegersProvider()
    {
        return [
            [ Options::COLUMNS ],
            [ Options::IMAGE_CELL_SIZE ],
            [ Options::IMAGE_HUE ],
            [ Options::NEIGHBORHOOD_SIZE, ],
            [ Options::ROWS, ],
            [ Options::STATES, ],
            [ Options::THRESHOLD, ],
        ];
    }

    /**
     * @test
     */
    public function itAcceptsValidImageColors()
    {
        $result = Validator::validate([
            Options::IMAGE_COLORS => [
                new RgbColor(255, 255, 255),
                new RgbColor(0, 0, 0),
            ],
        ]);

        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function itThrowsAnErrorUponSettingNonArrayImageColors()
    {
        $this->expectException(InvalidValueException::class);

        Validator::validate([
            Options::IMAGE_COLORS => new RgbColor(255, 255, 255),
        ]);
    }

    /**
     * @test
     */
    public function itThrowsAnErrorUponSettingInvalidImageColors()
    {
        $this->expectException(InvalidValueException::class);

        Validator::validate([
            Options::IMAGE_COLORS => [
                "#FFCC00",
            ],
        ]);
    }

    /**
     * @test
     */
    public function itAcceptsValidImageHues()
    {
        $result = Validator::validate([
            Options::IMAGE_HUE => 123,
        ]);

        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function itThrowsAnErrorUponSettingTooLargeImageHue()
    {
        $this->expectException(InvalidValueException::class);

        Validator::validate([
            Options::IMAGE_HUE => 361,
        ]);
    }


    /**
     * @test
     */
    public function itAcceptsValidNeighborhoodType()
    {
        $result = Validator::validate([
            Options::NEIGHBORHOOD_TYPE => NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE,
        ]);

        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function itThrowsAnErrorUponSettingInvalidNeighborhoodType()
    {
        $this->expectException(InvalidValueException::class);

        Validator::validate([
            Options::NEIGHBORHOOD_TYPE => "MOOORE",
        ]);
    }
}
