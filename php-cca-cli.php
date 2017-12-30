#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Barryvanveen\CCA\RunCCACommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->setCatchExceptions(true);
$application->add(new RunCCACommand());
$application->run();