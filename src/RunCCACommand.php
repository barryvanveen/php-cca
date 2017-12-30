<?php

namespace Barryvanveen\CCA;

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
        $cca = new CCA();

        $cca->init();

        $cca->printCells();

        $cca->cycle();

        $cca->printCells();

        $cca->cycle();

        $cca->printCells();

        $cca->cycle();

        $cca->printCells();

        $cca->cycle();

        $cca->printCells();
    }
}
