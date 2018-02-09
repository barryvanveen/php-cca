<?php

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Config\Presets::PRESET_GH;
$maxIterations = 100;
$output = __DIR__."/output/animated-gh.gif";

$config = Config::createFromPreset($preset);

$runner = new Runner($config);
$states = $runner->getFirstStates($maxIterations);

$image = AnimatedGif::createFromStates($config, $states);
$image->save($output);
