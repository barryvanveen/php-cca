<?php

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Factories\CCAFactory;
use Barryvanveen\CCA\Generators\Gif;
use Barryvanveen\CCA\Runner;
use Phim\Color;

require __DIR__."/../vendor/autoload.php";

$preset = Presets::PRESET_313;
$maxIterations = 150;
$output = __DIR__."/output/static-313-with-custom-colors.gif";

$builder = new \Barryvanveen\CCA\Builders\ConfigBuilder();
$builder->createFromPreset($preset);
$builder->imageCellSize(2);
$builder->imageColors([
   Color::get(Color::BRIGHTPINK),
   Color::get(Color::CANDYPINK),
   Color::get(Color::CHERRYBLOSSOMPINK),
]);

$config = $builder->get();

$runner = new Runner($config, CCAFactory::create($config));
$state = $runner->getLastState($maxIterations);

$image = Gif::createFromState($config, $state);
$image->save($output);
