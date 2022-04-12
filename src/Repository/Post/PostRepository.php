<?php

namespace App\Repository\Post;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PostRepository
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
        $this->repository = $em->getRepository(Post::class);
    }

    public function add(Post $post)
    {
        $this->em->persist($post);
    }

    public function findAll()
    {
        return $this->repository
            ->createQueryBuilder('post')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findAllAsArray()
    {
        return $this->repository
            ->createQueryBuilder('post')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findOneBySlug(string $slug)
    {
        return $this->repository->findOneBy(['slugg' => $slug]);
    }

    public function getRandomPost()
    {
        $count = $this->repository
            ->createQueryBuilder('post')
            ->select('count(post.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $randomInt = rand(0, $count - 1);

        $randomPost = $this->repository
            ->createQueryBuilder('post')
            ->orderBy('post.id', 'DESC')
            ->setFirstResult($randomInt)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $randomPost;
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
