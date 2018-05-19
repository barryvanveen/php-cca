<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\OldConfig;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\Png;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_CUBISM;
$maxIterations = 100;
$output = __DIR__."/output/static-cubism.png";

$config = OldConfig::createFromPreset($preset);
$config->rows(150);
$config->columns(400);
$config->imageCellSize(5);

$runner = new Runner($config, CCAFactory::create($config));
$state = $runner->getLastState($maxIterations);

$image = Png::createFromState($config, $state);
$image->save($output);
