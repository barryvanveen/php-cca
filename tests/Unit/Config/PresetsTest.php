<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Config;

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\InvalidPresetException;

/**
 * @covers \Barryvanveen\CCA\Config\Presets
 */
class PresetsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function itReturnsAnArrayOfConfigurationValues()
    {
        $presetOptions = Presets::getPresetOptions(Presets::PRESET_313);

        $this->assertInternalType("array", $presetOptions);
    }

    /**
     * @test
     */
    public function itThrowsAnExceptionWhenGivenAnInvalidPreset()
    {
        $this->expectException(InvalidPresetException::class);

        Presets::getPresetOptions('invalid_preset_value');
    }
}
