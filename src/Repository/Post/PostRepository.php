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

    public function findOneBySlug(string $slug)
    {
        return $this->repository->findOneBy(['slugg' => $slug]);
    }
}
