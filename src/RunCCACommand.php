<?php

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Generators\Gif;
use GifCreator\AnimGif;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCCACommand extends Command
{
    protected function configure()
    {
        $this->setName('cca:run')
            ->setDescription('Run a Cyclic Cellular Automaton.')
            ->setHelp('This command runs a Cyclic Cellular Automaton and outputs its contents.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $starttime = microtime(true);

        $config = new Config();

        // Rule = 313
        $config->states(3);
        $config->threshold(3);
        $config->neighborhoodType(Config::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(1);

        // Rule = GH
        /*$config->states(8);
        $config->threshold(5);
        $config->neighborhoodType(Config::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(3);*/

        // Rule = LavaLamp
        /*$config->states(3);
        $config->threshold(10);
        $config->neighborhoodType(Config::NEIGHBORHOOD_TYPE_MOORE);
        $config->neighborhoodSize(2);*/

        $cca = new CCA($config);

        $cca->init();

        $this->reportTime($output, "CCA initialized.", $starttime);

        do {
            $states[] = $cca->getState();

            $generation = $cca->cycle();
        } while($generation < 100);

        $this->reportTime($output, "Generated states.", $starttime);

        foreach($states as $state) {
            $images[] = Gif::createFromState($state)->get();
        }

        $this->reportTime($output, "Generated images.", $starttime);

        $animation = new AnimGif();
        $animation->create($images);
        $animation->save("output/test.gif");

        $this->reportTime($output, "Generated animated gif.", $starttime);

        return;
    }

    protected function reportTime(OutputInterface $output, string $message, float $starttime)
    {
        $formatter = $this->getHelper('formatter');

        $endtime = microtime(true);

        $duration = round($endtime - $starttime, 2);

        $output->writeln("[$duration] $message");
    }
}
