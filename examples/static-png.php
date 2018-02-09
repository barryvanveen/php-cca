<?php

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Generators\Png;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Config\Presets::PRESET_CUBISM;
$maxIterations = 100;
$output = __DIR__."/output/static-cubism.png";

$config = Config::createFromPreset($preset);
$config->rows(150);
$config->columns(400);
$config->imageCellSize(5);

$runner = new Runner($config);
$state = $runner->getSingleState($maxIterations);

$image = Png::createFromState($config, $state);
$image->save($output);
