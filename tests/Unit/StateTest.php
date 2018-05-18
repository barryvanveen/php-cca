<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Factories\GridFactory;
use Barryvanveen\CCA\State;

/**
 * @covers \Barryvanveen\CCA\State
 */
class StateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function itReturnsAnArray()
    {
        $config = Config::createFromPreset(Config\Presets::PRESET_313);
        $config->rows(10);
        $config->columns(10);

        $grid = GridFactory::create($config);

        $state = new State($grid);

        $this->assertCount(100, $state->toArray());
    }

    /**
     * @test
     */
    public function itReturnsAHash()
    {
        $config = Config::createFromPreset(Config\Presets::PRESET_313);
        $config->rows(10);
        $config->columns(10);

        $grid = GridFactory::create($config);

        $state = new State($grid);

        $this->assertEquals(8, strlen($state->toHash()));
    }

    /**
     * @test
     */
    public function itReturnsAString()
    {
        $config = Config::createFromPreset(Config\Presets::PRESET_313);
        $config->rows(10);
        $config->columns(10);

        $grid = GridFactory::create($config);

        $state = new State($grid);

        $this->assertStringStartsWith("  0 1 2 3 4 5 6 7 8 9 ", $state->__toString());
    }
}
