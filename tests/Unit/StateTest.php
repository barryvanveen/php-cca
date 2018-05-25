<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config\Presets;
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
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_313);
        $builder->rows(10);
        $builder->columns(10);

        $config = $builder->get();

        $grid = GridFactory::create($config);

        $state = new State($grid);

        $this->assertCount(100, $state->toArray());
    }

    /**
     * @test
     */
    public function itReturnsAHash()
    {
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_313);
        $builder->rows(10);
        $builder->columns(10);

        $config = $builder->get();

        $grid = GridFactory::create($config);

        $state = new State($grid);

        $this->assertEquals(8, strlen($state->toHash()));
    }

    /**
     * @test
     */
    public function itReturnsAString()
    {
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_313);
        $builder->rows(10);
        $builder->columns(10);

        $config = $builder->get();

        $grid = GridFactory::create($config);

        $state = new State($grid);

        $this->assertStringStartsWith("  0 1 2 3 4 5 6 7 8 9 ", $state->__toString());
    }
}
