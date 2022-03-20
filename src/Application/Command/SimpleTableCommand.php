<?php

declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SimpleTableCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('command:simple-table')
            ->setDescription('Command print simple table in command line');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $roles = [
            [
                'id' => 1,
                'role' => 'ROLE_SUPERADMIN',
                'permissions' => \implode(', ', ['EDIT', 'CREATE', 'DELETE', 'CHANGE ROLE'])
            ],
            [
                'id' => 2,
                'role' => 'ROLE_ADMIN',
                'permissions' => \implode(', ', ['EDIT', 'CREATE', 'DELETE'])
            ],
            [
                'id' => 3,
                'role' => 'ROLE_EDITOR',
                'permissions' => \implode(', ', ['EDIT', 'CREATE'])
            ],
            [
                'id' => 4,
                'role' => 'ROLE_USER',
                'permissions' => \implode(', ', ['CREATE'])
            ]
        ];

        $table->setHeaders(['Id', 'Role', 'Rules'])->setRows($roles);

        $table->render();

        return 1;
    }
}