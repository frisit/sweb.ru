<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Post;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    private $slug;

    public function __construct(\Cocur\Slugify\SlugifyInterface $slugify)
    {
        $this->faker = Factory::create();
        $this->slug = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadPosts($manager);
    }

    public function loadPosts(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $title = $this->faker->text(100);

            $post = Post::fromDraft(
                $this->getReference(UserFixtures::USER_REFERENCE),
                $title,
                $this->faker->text(400),
                $this->slug->slugify($title)
            );

            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
