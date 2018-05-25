<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Factories;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Factories\CCAFactory;

class CCAFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Factories\CCAFactory::create()
     */
    public function itReturnsACCA()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);
        $builder->states(3);

        $config = $builder->get();

        $cca = CCAFactory::create($config);

        $this->assertInstanceOf(CCA::class, $cca);
    }
}
