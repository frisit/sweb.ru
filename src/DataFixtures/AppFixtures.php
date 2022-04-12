<?php

namespace App\DataFixtures;

use App\Entity\Post\Category;
use App\Entity\Post\Comment;
use App\Repository\Post\CategoryRepository;
use App\Repository\Post\PostRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Post\Post;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    private $slug;

    private PostRepository $postRepository;

    private CategoryRepository $categoryRepository;

    public function __construct(
        \Cocur\Slugify\SlugifyInterface $slugify,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository
    )    {
        $this->faker = Faker\Factory::create('ru_RU');
        $this->slug = $slugify;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
        $this->loadPosts($manager);
        $this->loadComments($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadCategories(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++)
        {
            $title = $this->faker->realText(30, true);
            $category = new Category(rtrim($title, '.'));

            $manager->persist($category);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadPosts(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $title = $this->faker->realText(30, 2);

            $post = Post::fromDraft(
                $this->getReference(UserFixtures::USER_REFERENCE),
                rtrim($title, '.'),
                $this->faker->realText(400),
                $this->slug->slugify($title),
                $this->categoryRepository->getRandomCategory()
            );

            $manager->persist($post);
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {
        for($i = 1; $i <= 200; $i++) {
            $content = $this->faker->realText(150);
            $user = $this->getReference(UserFixtures::USER_REFERENCE);
            $post = $this->postRepository->getRandomPost();

            $comment = Comment::create($content, $user, $post);

            $manager->persist($comment);
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
