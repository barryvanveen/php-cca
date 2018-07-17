<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\Png;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_CUBISM;
$maxIterations = 100;
$output = __DIR__."/output/static-cubism.png";

$builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
$builder->createFromPreset($preset);
$builder->rows(150);
$builder->columns(400);
$builder->imageCellSize(5);

$config = $builder->get();

$runner = new Runner($config, CCAFactory::create($config));
$state = $runner->getLastState($maxIterations);

$image = Png::createFromState($config, $state);
$image->save($output);
