<?php

declare(strict_types=1);

namespace Barryvanveen\CCA\Tests\Unit\Generators;

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Factories\CCAFactory;
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
        $builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
        $builder->createFromPreset(Presets::PRESET_CCA);
        $builder->seed(1);
        $builder->columns(5);
        $builder->rows(10);
        $builder->imageCellSize(1);
        $builder->imageHue(1);

        $config = $builder->get();

        $runner = new Runner($config, CCAFactory::create($config));
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
