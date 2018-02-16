<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Generators\Gif;
use Barryvanveen\CCA\Runner;
use Barryvanveen\CCA\Tests\Functional\FunctionalTestCase;

/**
 * @covers \Barryvanveen\CCA\Generators\Gif
 * @covers \Barryvanveen\CCA\Generators\Image
 */
class StaticGifTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function itCreatesAStaticGifImage()
    {
        $config = Config::createFromPreset(Presets::PRESET_CCA);
        $config->seed(1);
        $config->columns(5);
        $config->rows(10);
        $config->imageCellSize(1);
        $config->imageHue(1);

        $runner = new Runner($config);
        $state = $runner->getLastState(3);

        $this->assertFileNotExists($this->getImageFilename());

        $image = Gif::createFromState($config, $state);
        $image->save($this->getImageFilename());

        $this->assertFileExists($this->getImageFilename());

        $imagesize = getimagesize($this->getImageFilename());
        $this->assertEquals(5, $imagesize[0]);
        $this->assertEquals(10, $imagesize[1]);
        $this->assertEquals("image/gif", $imagesize['mime']);
    }

    /**
     * @test
     */
    public function itCreatesALargerStaticGifImage()
    {
        $config = Config::createFromPreset(Presets::PRESET_CCA);
        $config->seed(1);
        $config->columns(5);
        $config->rows(10);
        $config->imageCellSize(3);
        $config->imageHue(1);

        $runner = new Runner($config);
        $state = $runner->getLastState(3);

        $this->assertFileNotExists($this->getImageFilename());

        $image = Gif::createFromState($config, $state);
        $image->save($this->getImageFilename());

        $this->assertFileExists($this->getImageFilename());

        $imagesize = getimagesize($this->getImageFilename());
        $this->assertEquals(15, $imagesize[0]);
        $this->assertEquals(30, $imagesize[1]);
        $this->assertEquals("image/gif", $imagesize['mime']);
    }

    public function getImageFilename(): string
    {
        return __DIR__."/static.gif";
    }
}
