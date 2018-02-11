<?php

namespace Barryvanveen\CCA\Tests\Unit;

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Exceptions\LoopNotFoundException;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

/**
 * @coversNothing
 */
class LoopingAnimatedGifTest extends \PHPUnit\Framework\TestCase
{
    protected $imageFilename = __DIR__."/looping.gif";

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
        $config->rows(10);
        $config->columns(10);

        $runner = new Runner($config);
        $states = $runner->getFirstLoop(500);

        $gif = AnimatedGif::createFromStates($config, $states);
        $gif->save($this->imageFilename);

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
