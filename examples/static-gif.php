<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\Gif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_CCA;
$maxIterations = 300;
$output = __DIR__."/output/static-cca.gif";

$builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
$builder->createFromPreset($preset);
$builder->rows(100);
$builder->columns(100);
$builder->imageCellSize(5);

$config = $builder->get();

$runner = new Runner($config, CCAFactory::create($config));
$state = $runner->getLastState($maxIterations);

$image = Gif::createFromState($config, $state);
$image->save($output);
