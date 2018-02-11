<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Generators\Gif;
use Barryvanveen\CCA\Runner;

/**
 * @coversNothing
 */
class StaticGifTest extends \PHPUnit\Framework\TestCase
{
    protected $imageFilename = __DIR__."/static.gif";

    public function setUp()
    {
        parent::setUp();

        if (file_exists($this->imageFilename)) {
            unlink($this->imageFilename);
        }
    }

    /**
     * @test
     */
    public function itCreatesAStaticGifImage()
    {
        $config = Config::createFromPreset(Presets::PRESET_CCA);
        $config->seed(1);
        $config->rows(10);
        $config->columns(10);
        $config->imageHue(1);

        $runner = new Runner($config);
        $state = $runner->getSingleState(3);

        $this->assertFileNotExists($this->imageFilename);

        $image = Gif::createFromState($config, $state);
        $image->save($this->imageFilename);

        $this->assertFileExists($this->imageFilename);
    }

    public function tearDown()
    {
        if (file_exists($this->imageFilename)) {
            unlink($this->imageFilename);
        }

        parent::tearDown();
    }
}
