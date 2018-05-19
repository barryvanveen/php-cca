<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Factories;

use Barryvanveen\CCA\Factories\GridFactory;
use Barryvanveen\CCA\OldConfig;
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
        /** @var OldConfig|MockObject $configMock */
        $configMock = $this->getMockBuilder(OldConfig::class)
            ->setMethods(['seed'])
            ->getMock();

        $configMock->expects($this->once())
            ->method('seed');

        $configMock->rows(5);
        $configMock->columns(5);
        $configMock->states(3);

        GridFactory::create($configMock);
    }

    /**
     * @test
     *
     * @coversNothing
     */
    public function itReturnsDifferentStatesForDifferentSeeds()
    {
        $config = new OldConfig;
        $config->rows(5);
        $config->columns(5);
        $config->states(3);
        $config->seed(123);

        $grid1 = GridFactory::create($config);
        $state1 = $grid1->toArray();

        $config->seed(321);
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
        $config = new OldConfig;
        $config->rows(5);
        $config->columns(5);
        $config->states(3);
        $config->seed(123);

        $grid1 = GridFactory::create($config);
        $state1 = $grid1->toArray();

        $grid2 = GridFactory::create($config);
        $state2 = $grid2->toArray();

        $this->assertEquals($state1, $state2);
    }
}
