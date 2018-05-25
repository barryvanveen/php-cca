<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_GH;
$maxIterations = 100;
$output = __DIR__."/output/animated-gh.gif";

$builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
$config = $builder->createFromPreset($preset)->get();

$runner = new Runner($config, CCAFactory::create($config));
$states = $runner->getFirstStates($maxIterations);

$image = AnimatedGif::createFromStates($config, $states);
$image->save($output);
