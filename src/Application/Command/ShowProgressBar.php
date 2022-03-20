<?php

declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ShowProgressBar extends Command
{
    protected function configure(): void
    {
        $this->setName('command:show-progress-bar')
            ->setDescription('This command show progressbar');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $progressBar = $io->createProgressBar(100);

        for ($i = 0; $i < 100; $i++) {
            \sleep(1);

            $progressBar->advance();
        }

        $progressBar->finish();

        return 1;
    }
}