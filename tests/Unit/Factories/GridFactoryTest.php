<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Factories;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Factories\GridFactory;
use PHPUnit\Framework\MockObject\MockObject;

class GridFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @covers \Barryvanveen\CCA\Factories\GridFactory::create()
     * @covers \Barryvanveen\CCA\Factories\GridFactory::setSeed()
     * @covers \Barryvanveen\CCA\Factories\GridFactory::getCells()
     * @covers \Barryvanveen\CCA\Factories\GridFactory::getNeighbors()
     */
    public function itSeedsTheRandomNumbersOnConstruct()
    {
        /** @var Config|MockObject $configMock */
        $configMock = $this->getMockBuilder(Config::class)
            ->setConstructorArgs([
                [],
            ])
            ->setMethods(['seed'])
            ->getMock();

        $configMock->expects($this->once())
            ->method('seed');

        GridFactory::create($configMock);
    }

    /**
     * @test
     *
     * @coversNothing
     */
    public function itReturnsDifferentStatesForDifferentSeeds()
    {
        $builder = new ConfigBuilder();
        $builder->seed(123);

        $config = $builder->get();

        $grid1 = GridFactory::create($config);
        $state1 = $grid1->toArray();

        $builder->seed(321);
        $config = $builder->get();

        $grid2 = GridFactory::create($config);
        $state2 = $grid2->toArray();

        $this->assertNotEquals($state1, $state2);
    }

    /**
     * @test
     *
     * @coversNothing
     */
    public function itReturnsEqualStatesForEqualSeeds()
    {
        $builder = new ConfigBuilder();
        $builder->seed(123);

        $config = $builder->get();

        $grid1 = GridFactory::create($config);
        $state1 = $grid1->toArray();

        $grid2 = GridFactory::create($config);
        $state2 = $grid2->toArray();

        $this->assertEquals($state1, $state2);
    }
}
