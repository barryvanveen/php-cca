<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\OldConfig;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_313;
$maxIterations = 1000;
$output = __DIR__."/output/looping-313.gif";

$config = OldConfig::createFromPreset($preset);

$runner = new Runner($config, CCAFactory::create($config));
$states = $runner->getFirstLoop($maxIterations);

$image = AnimatedGif::createFromStates($config, $states);
$image->save($output);
