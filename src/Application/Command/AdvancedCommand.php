<?php

declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class AdvancedCommand extends Command
{
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('command:advance')
            ->setDescription('This command will ask you for name and surname and print them back.')
            ->addOption('surname', 's', InputOption::VALUE_REQUIRED)
            ->addOption('name', 'm', InputOption::VALUE_REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $surname = $input->getOption('surname');
        $name = $input->getOption('name');

        $io->success("Your full name: $surname $name");

        return 1;
    }


}