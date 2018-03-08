<?php

namespace Barryvanveen\CCA\Tests\Unit\Generators;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Generators\Png;
use Barryvanveen\CCA\Runner;

/**
 * @covers \Barryvanveen\CCA\Generators\Png
 * @covers \Barryvanveen\CCA\Generators\Image
 */
class StaticPngTest extends ImageTestCase
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

        $image = Png::createFromState($config, $state);
        $image->save($this->getImageFilename());

        $this->assertFileExists($this->getImageFilename());

        $imagesize = getimagesize($this->getImageFilename());
        $this->assertEquals(5, $imagesize[0]);
        $this->assertEquals(10, $imagesize[1]);
        $this->assertEquals("image/png", $imagesize['mime']);
    }

    public function getImageFilename(): string
    {
        return __DIR__."/static.gif";
    }
}
