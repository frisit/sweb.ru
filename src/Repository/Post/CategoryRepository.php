<?php

namespace App\Repository\Post;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Post\Category;

class CategoryRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Category::class);
    }

    public function add(Category $category)
    {
        $this->em->persist($category);
    }

    public function findAll()
    {
        return $this->repository
            ->createQueryBuilder('category')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findAllAsArray()
    {
        return $this->repository
            ->createQueryBuilder('category')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function getRandomCategory()
    {
        $count = $this->repository
            ->createQueryBuilder('category')
            ->select('count(category.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $randomInt = rand(0, $count-1);

        $randomPost = $this->repository
            ->createQueryBuilder('category')
            ->orderBy('category.id', 'DESC')
            ->setFirstResult($randomInt)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $randomPost;
    }
}