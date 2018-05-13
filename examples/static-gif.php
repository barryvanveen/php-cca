<?php

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\Gif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Config\Presets::PRESET_CCA;
$maxIterations = 300;
$output = __DIR__."/output/static-cca.gif";

$config = Config::createFromPreset($preset);
$config->rows(100);
$config->columns(100);
$config->imageCellSize(5);

$runner = new Runner($config, CCAFactory::create($config));
$state = $runner->getLastState($maxIterations);

$image = Gif::createFromState($config, $state);
$image->save($output);
