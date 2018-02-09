<?php

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Config\Presets::PRESET_313;
$maxIterations = 1000;
$output = __DIR__."/output/looping-313.gif";

$config = Config::createFromPreset($preset);

$runner = new Runner($config);
$states = $runner->getFirstLoop($maxIterations);

$image = AnimatedGif::createFromStates($config, $states);
$image->save($output);
