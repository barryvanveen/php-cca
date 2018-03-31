<?php

namespace Barryvanveen\CCA\Tests\Unit\Generators;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\LoopNotFoundException;
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
        $config = Config::createFromPreset(Presets::PRESET_CCA);
        $config->seed(1);
        $config->rows(10);
        $config->columns(10);
        $config->imageHue(1);

        $this->expectException(LoopNotFoundException::class);

        $runner = new Runner($config);
        $runner->getFirstLoop(1);
    }

    /**
     * @test
     */
    public function itCreatesAnAnimatedGifImage()
    {
        $config = Config::createFromPreset(Presets::PRESET_GH);
        $config->seed(1);
        $config->columns(8);
        $config->rows(10);
        $config->imageCellSize(1);

        $runner = new Runner($config);
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
