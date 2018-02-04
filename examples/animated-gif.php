<?php

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

require "../vendor/autoload.php";

$preset = Config\Presets::PRESET_313;
$maxIterations = 100;
$output = 'output/animated-313.gif';

$config = Config::createFromPreset($preset);

$runner = new Runner($config);
$states = $runner->getFirstStates($maxIterations);

$image = AnimatedGif::createFromStates($config, $states);
$image->save($output);
