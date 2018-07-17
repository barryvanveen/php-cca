<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Generators;

use Barryvanveen\CCA\Builders\ConfigBuilder;
use Barryvanveen\CCA\CCA;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\LoopNotFoundException;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;
use Barryvanveen\CCA\Tests\Unit\MockHelper;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Barryvanveen\CCA\Generators\AnimatedGif
 * @covers \Barryvanveen\CCA\Generators\Image
 */
class LoopingAnimatedGifTest extends ImageTestCase
{
    use MockHelper;

    /**
     * @test
     */
    public function itCannotFindALoop()
    {
        $builder = ConfigBuilder::createFromPreset(Presets::PRESET_313);
        $builder->seed(1);
        $builder->imageHue(1);

        $config = $builder->get();

        $this->expectException(LoopNotFoundException::class);

        $runner = new Runner($config, CCAFactory::create($config));
        $runner->getFirstLoop(1);
    }

    /**
     * @test
     */
    public function itCreatesAnAnimatedGifImage()
    {
        /** @var CCA|MockObject $mockCCA */
        list($mockCCA, $config, $state1, $state2, $state3) = $this->getCCAMockWithLoopingStates();

        $runner = new Runner($config, $mockCCA);
        $states = $runner->getFirstLoop(3);

        $gif = AnimatedGif::createFromStates($config, $states);
        $gif->save($this->getImageFilename());

        $this->assertFileExists($this->getImageFilename());

        $imagesize = getimagesize($this->getImageFilename());
        $this->assertEquals(10, $imagesize[0]);
        $this->assertEquals(10, $imagesize[1]);
        $this->assertEquals("image/gif", $imagesize['mime']);
    }

    public function getImageFilename(): string
    {
        return __DIR__."/looping.gif";
    }
}
