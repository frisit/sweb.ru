<?php

declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class SetUserRoleCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('command:set-user-role')
            ->setDescription('This command emulate set role for user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

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

        do {
            $role = $io->ask('Set role id for user');
        } while (null === $role);

        do {
            $email = $io->ask('Set users email');
        } while (null === $email);

        $io->success("To user with email $email will be set role $role");

        $result = $io->confirm('Confirm?');

        if (true === $result) {
            $io->success('Role is set');
        }

        return 1;
    }
}