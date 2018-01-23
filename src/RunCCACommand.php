<?php

namespace Barryvanveen\CCA;

use Barryvanveen\CCA\Config\Presets;
use Barryvanveen\CCA\Generators\Gif;
use GifCreator\AnimGif;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCCACommand extends Command
{
    protected $states = [];

    protected $hashes = [];

    protected function configure()
    {
        $this->setName('cca:run')
            ->setDescription('Run a Cyclic Cellular Automaton.')
            ->setHelp('This command runs a Cyclic Cellular Automaton and outputs its contents.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $starttime = microtime(true);

        $config = Config::createFromPreset(Presets::PRESET_313);

        // or create it manually
        //$config = new Config();
        //$config->columns(100);
        //$config->neighborhoodSize(1);
        //$config->neighborhoodType(NeighborhoodOptions::NEIGHBORHOOD_TYPE_MOORE);
        //$config->rows(100);
        //$config->states(10);
        //$config->threshold(10);

        $cca = new CCA($config);
        $cca->init();

        // or create it from a state
        // $cca->loadState(...) @todo

        $this->reportTime($output, "CCA initialized.", $starttime);

        do {
            $state = $cca->getState();
            $hash = hash('crc32', $state);

            $cycleEnd = false;
            if ($cycleStart = array_search($hash, $this->hashes)) {
                $cycleEnd = count($this->states)+1;
            }

            $this->states[] = $state;
            $this->hashes[] = $hash;

            if ($cycleEnd !== false) {
                $this->states = array_slice($this->states, $cycleStart, $cycleEnd);
                $this->hashes = array_slice($this->hashes, $cycleStart, $cycleEnd);

                $output->writeln(sprintf("Cycle detected between frame %d and %d", $cycleStart, $cycleEnd));

                break;
            }

            $generation = $cca->cycle();
        } while ($generation < 10000);

        $this->reportTime($output, "Generated states.", $starttime);

        foreach ($this->states as $state) {
            $images[] = Gif::createFromState($state)->get();
        }

        $this->reportTime($output, "Generated images.", $starttime);

        $animation = new AnimGif();
        $animation->create($images);
        $animation->save("output/test.gif");

        $this->reportTime($output, "Generated animated gif.", $starttime);

        $this->reportConfig($output, $config);

        return;
    }

    protected function reportTime(OutputInterface $output, string $message, float $starttime)
    {
        $endtime = microtime(true);

        $duration = round($endtime - $starttime, 2);

        $output->writeln("[$duration] $message");
    }

    protected function reportConfig(OutputInterface $output, Config $config)
    {
        $output->writeln("Generated with config:");
        $output->writeln(sprintf(" > %s: %s", "seed", $config->seed()));
        $output->writeln(sprintf(" > %s: %s", "rows", $config->rows()));
        $output->writeln(sprintf(" > %s: %s", "columns", $config->columns()));
        $output->writeln(sprintf(" > %s: %s", "states", $config->states()));
        $output->writeln(sprintf(" > %s: %s", "threshold", $config->threshold()));
        $output->writeln(sprintf(" > %s: %s", "neighborhood type", $config->neighborhoodType()));
        $output->writeln(sprintf(" > %s: %s", "neighborhood size", $config->neighborhoodSize()));
    }
}
