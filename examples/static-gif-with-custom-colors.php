<?php

use Barryvanveen\CCA\Config;
use Barryvanveen\CCA\Generators\Gif;
use Barryvanveen\CCA\Runner;
use Phim\Color;

require __DIR__."/../vendor/autoload.php";

$preset = Config\Presets::PRESET_313;
$maxIterations = 150;
$output = __DIR__."/output/static-313-with-custom-colors.gif";

$config = Config::createFromPreset($preset);
$config->imageCellSize(2);
$config->imageColors([
   Color::get(Color::BRIGHTPINK),
   Color::get(Color::CANDYPINK),
   Color::get(Color::CHERRYBLOSSOMPINK),
]);

$runner = new Runner($config);
$state = $runner->getLastState($maxIterations);

$image = Gif::createFromState($config, $state);
$image->save($output);
