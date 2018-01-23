<?php

namespace Barryvanveen\CCA\Tests;

use Barryvanveen\CCA\Config;
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
    public function it_returns_an_array_of_configuration_values()
    {
        $presetOptions = Presets::getPresetConfig(Presets::PRESET_313);

        $this->assertInternalType("array", $presetOptions);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_given_an_invalid_preset()
    {
        $this->expectException(InvalidPresetException::class);

        Presets::getPresetConfig('invalid_preset_value');
    }

    /**
     * @test
     */
    public function all_presets_should_return_valid_config_options_and_values()
    {
        $config = new Config();

        foreach (Presets::VALID_PRESETS as $preset) {
            $presetOptions = Presets::getPresetConfig($preset);

            $this->assertInternalType("array", $presetOptions);

            foreach ($presetOptions as $option => $value) {
                $this->assertContains($option, Config\Options::VALID_OPTIONS);

                try {
                    $config->{$option}($value); // this line should not trigger an error
                } catch (\Exception $e) {
                    $this->fail("Preset ".$preset." contains invalid option ".$option." with value ".$value);
                }
            }
        }
    }
}
