<?php

namespace Barryvanveen\CCA\Tests\Unit\Generators;

use Barryvanveen\CCA\Config;
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
        $config = Config::createFromPreset(Presets::PRESET_CCA);
        $config->seed(1);
        $config->columns(10);
        $config->rows(10);
        $config->imageCellSize(1);
        $config->imageHue(1);

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
        $config = Config::createFromPreset(Presets::PRESET_CCA);
        $config->seed(1);
        $config->columns(10);
        $config->rows(10);
        $config->imageCellSize(1);
        $config->imageHue(1);

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
