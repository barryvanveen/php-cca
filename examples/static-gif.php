<?php

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Generators\Gif;
use Barryvanveen\CCA\Runner;

require __DIR__."/../vendor/autoload.php";

$preset = Config\Presets::PRESET_313;
$maxIterations = 100;
$output = __DIR__."/output/static-313.gif";

$config = Config::createFromPreset($preset);

$runner = new Runner($config);
$state = $runner->getSingleState($maxIterations);

$image = Gif::createFromState($config, $state);
$image->save($output);
