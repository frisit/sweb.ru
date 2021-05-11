<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/posts/new", name="new_blog_post")
     */
    public function addPost(Request $request, Slugify $slugify)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($slugify->slugify($post->getTitle()));
            $post->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        };

        return new Response (json_encode(['message' => 'success']), 200);

//        return $this->render('posts/new.html.twig', [
//            'form' => $form->createView()
//        ]);
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
