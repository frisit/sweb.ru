<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /** @var PostRepository $postRepository */
    private $postRepository;

    /**
     * @Route("/posts", name="blog_posts")
     * */
    public function posts()
    {
        $repo = $this->getDoctrine()->getRepository(Post::class);

        $posts = $repo->findAll();

        return $this->render('posts/index.html.twig', [
           'posts' => $posts
        ]);
    }

    /**
     * @Route("/posts/{slug}", name="blog_show")
     * */
    public function post(Post $post)
    {
        return $this->render('posts/show.html.twig', [
            'post' => $post
        ]);
    }
}
