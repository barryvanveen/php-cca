<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Generators;

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\LoopNotFoundException;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

/**
 * @covers \Barryvanveen\CCA\Generators\AnimatedGif
 * @covers \Barryvanveen\CCA\Generators\Image
 */
class LoopingAnimatedGifTest extends ImageTestCase
{
    /**
     * @test
     */
    public function itCannotFindALoop()
    {
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_CCA);
        $builder->seed(1);
        $builder->rows(10);
        $builder->columns(10);
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
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_GH);
        $builder->seed(1);
        $builder->columns(8);
        $builder->rows(10);
        $builder->imageCellSize(1);

        $config = $builder->get();

        $runner = new Runner($config, CCAFactory::create($config));
        $states = $runner->getFirstLoop(500);

        $gif = AnimatedGif::createFromStates($config, $states);
        $gif->save($this->getImageFilename());

        $this->assertFileExists($this->getImageFilename());

        $imagesize = getimagesize($this->getImageFilename());
        $this->assertEquals(8, $imagesize[0]);
        $this->assertEquals(10, $imagesize[1]);
        $this->assertEquals("image/gif", $imagesize['mime']);
    }

    public function getImageFilename(): string
    {
        return __DIR__."/looping.gif";
    }
}
