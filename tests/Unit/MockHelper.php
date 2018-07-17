<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Factories\GridFactory;
use Barryvanveen\CCA\State;
use PHPUnit\Framework\MockObject\MockObject;

trait MockHelper
{
    public function getCCAMockWithNormalStates()
    {
        /** @var CCA|MockObject $mockCCA */
        $mockCCA = $this->createMock(CCA::class);

        list($config, $state1, $state2, $state3) = $this->getNormalStates();

        $mockCCA->expects($this->exactly(3))
            ->method('getState')
            ->willReturnOnConsecutiveCalls(
                $state1,
                $state2,
                $state3
            );

        return [
            $mockCCA,
            $config,
            $state1,
            $state2,
            $state3,
        ];
    }

    protected function getNormalStates()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);

        $builder->seed(1);
        $config = $builder->get();
        $state1 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state2 = new State(GridFactory::create($config));

        $builder->seed(3);
        $config = $builder->get();
        $state3 = new State(GridFactory::create($config));

        return [
            $config,
            $state1,
            $state2,
            $state3,
        ];
    }

    public function getCCAMockWithLoopingStates()
    {
        /** @var CCA|MockObject $mockCCA */
        $mockCCA = $this->createMock(CCA::class);

        list($config, $state1, $state2, $state3) = $this->getLoopingStates();

        $mockCCA->expects($this->exactly(3))
            ->method('getState')
            ->willReturnOnConsecutiveCalls(
                $state1,
                $state2,
                $state3
            );

        return [
            $mockCCA,
            $config,
            $state1,
            $state2,
            $state3,
        ];
    }

    protected function getLoopingStates()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);

        // $state1 and $state3 are equal -> first loop should [$state1 $state2]

        $builder->seed(1);
        $config = $builder->get();
        $state1 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state2 = new State(GridFactory::create($config));

        $builder->seed(1);
        $config = $builder->get();
        $state3 = new State(GridFactory::create($config));

        return [
            $config,
            $state1,
            $state2,
            $state3,
        ];
    }

    public function getCCAMockWithEqualStates()
    {
        /** @var CCA|MockObject $mockCCA */
        $mockCCA = $this->createMock(CCA::class);

        list($config, $state1, $state2, $state3) = $this->getEqualStates();

        $mockCCA->expects($this->exactly(3))
            ->method('getState')
            ->willReturnOnConsecutiveCalls(
                $state1,
                $state2,
                $state3
            );

        return [
            $mockCCA,
            $config,
            $state1,
            $state2,
            $state3,
        ];
    }

    protected function getEqualStates()
    {
        $builder = new ConfigBuilder();
        $builder->rows(5);
        $builder->columns(5);

        // $state2 and $state3 are equal -> should fail because loop length is 1

        $builder->seed(1);
        $config = $builder->get();
        $state1 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state2 = new State(GridFactory::create($config));

        $builder->seed(2);
        $config = $builder->get();
        $state3 = new State(GridFactory::create($config));

        return [
            $config,
            $state1,
            $state2,
            $state3,
        ];
    }
}
