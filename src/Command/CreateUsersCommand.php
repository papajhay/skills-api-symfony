<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-users',
    description: 'Create test users'
)]
class CreateUsersCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = [
            ['email' => 'admin@test.com', 'roles' => ['ROLE_ADMIN']],
            ['email' => 'user1@test.com', 'roles' => ['ROLE_USER']],
            ['email' => 'user2@test.com', 'roles' => ['ROLE_API_USER']],
        ];

        foreach ($users as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setRoles($data['roles']);
            $user->setFirstName('Test');
            $user->setLastName('User');
            $user->setIsActive(true);
            $user->setCreatedAt(new \DateTimeImmutable());

            $hashed = $this->hasher->hashPassword($user, 'password123');
            $user->setPassword($hashed);

            $this->em->persist($user);
        }

        $this->em->flush();

        $output->writeln('Users created successfully');

        return Command::SUCCESS;
    }
}