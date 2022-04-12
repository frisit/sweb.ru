<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'users';

    /** @var \Faker\Generator */
    public $faker;

    /**
     * UserFixtures constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->password);
            $user->setRoles($user::ROLE_VIEWER);
            $user->setEnabled(true);

            $manager->persist($user);
        }

        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user);
    }
}