<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\AnimatedGif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_313;
$maxIterations = 1000;
$output = __DIR__."/output/looping-313.gif";

$builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
$config = $builder->createFromPreset($preset)->get();

$runner = new Runner($config, CCAFactory::create($config));
$states = $runner->getFirstLoop($maxIterations);

$image = AnimatedGif::createFromStates($config, $states);
$image->save($output);
