<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Generators;

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;
use GifCreator\AnimGif;

/**
 * @covers \Barryvanveen\CCA\Generators\AnimatedGif
 * @covers \Barryvanveen\CCA\Generators\Image
 */
class AnimatedGifTest extends ImageTestCase
{
    /**
     * @test
     */
    public function itCreatesAnAnimatedGifImage()
    {
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_CCA);
        $builder->seed(1);
        $builder->columns(10);
        $builder->rows(10);
        $builder->imageCellSize(1);
        $builder->imageHue(1);

        $config = $builder->get();

        $runner = new Runner($config, CCAFactory::create($config));
        $states = $runner->getFirstStates(3);

        $this->assertFileNotExists($this->getImageFilename());

        $image = AnimatedGif::createFromStates($config, $states);
        $image->save($this->getImageFilename());

        $this->assertFileExists($this->getImageFilename());

        $imagesize = getimagesize($this->getImageFilename());
        $this->assertEquals(10, $imagesize[0]);
        $this->assertEquals(10, $imagesize[1]);
        $this->assertEquals("image/gif", $imagesize['mime']);
    }

    /**
     * @test
     */
    public function itReturnsAnAnimatedGifInstance()
    {
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_CCA);
        $builder->seed(1);
        $builder->columns(10);
        $builder->rows(10);
        $builder->imageCellSize(1);
        $builder->imageHue(1);

        $config = $builder->get();

        $runner = new Runner($config, CCAFactory::create($config));
        $states = $runner->getFirstStates(3);

        $image = AnimatedGif::createFromStates($config, $states);

        $this->assertInstanceOf(AnimGif::class, $image->get());
    }

    public function getImageFilename(): string
    {
        return __DIR__."/animated.gif";
    }
}
