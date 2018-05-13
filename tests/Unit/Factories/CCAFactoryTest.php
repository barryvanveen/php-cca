<?php

namespace Barryvanveen\CCA\Tests\Unit\Factories;

use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Config;
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
        $config = new Config;
        $config->rows(5);
        $config->columns(5);
        $config->states(3);

        $cca = CCAFactory::create($config);

        $this->assertInstanceOf(CCA::class, $cca);
    }
}
