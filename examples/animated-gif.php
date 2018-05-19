<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\OldConfig;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_GH;
$maxIterations = 100;
$output = __DIR__."/output/animated-gh.gif";

$config = OldConfig::createFromPreset($preset);

$runner = new Runner($config, CCAFactory::create($config));
$states = $runner->getFirstStates($maxIterations);

$image = AnimatedGif::createFromStates($config, $states);
$image->save($output);
