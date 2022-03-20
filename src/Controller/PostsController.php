<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Event\EventDispatcher;
use App\Event\RequestEvent;
use App\Event\RequestSubscriber;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /** @var PostRepository $postRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/posts", name="blog_posts")
     * */
    public function posts()
    {
        // TODO: сделать вывод в лог информацию об открытии страницы
        $dispatcher = new EventDispatcher();;
        $dispatcher->addSubscriber(new RequestSubscriber());

        $dispatcher->dispatch(new RequestEvent(new \stdClass(), [
            'name' => 'Page was opened'
        ]));

        // Первый способ вывода записей без внедрения PostRepository через конструктор
        $repo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repo->findAll();

        // Второй способ вывода записей через внедрение PostRepository
//        $posts = $this->postRepository->findAll();

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        };

//        Возврат JSON в качестве ответа экшена
//        return new Response (json_encode(['message' => 'success']), 200);

        return $this->render('posts/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/posts/{slug}/edit", name="blog_post_edit")
     * */
    public function edit(Post $post, Request $request, Slugify $slugify)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($slugify->slugify($post->getTitle()));
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('blog_show', [
                'slug' => $post->getSlug()
            ]);
        }

        return $this->render('posts/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/posts/{slug}/delete", name="blog_post_delete")
     * */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('blog_posts');
    }

    /**
     * @Route("/posts/search", name="blog_search")
     * */
    public function search(Request $request)
    {
        $query = $request->query->get('queue');
        $posts = $this->postRepository->findOneBySlug($query);

        return $this->render('posts/query_post.html.twig', [
            'posts' => $posts
        ]);

    }


    /**
     * @Route("/posts/{slug}", name="blog_show")
     * */
    public function commentNew(Post $post, Request $request, LoggerInterface $logger)
    {
        if ($this->getUser() !== null) {
            $comment = new Comment();
            $comment->setUser($this->getUser());
            $post->addComment($comment);

            $form = $this->createForm(CommentType::class, $comment);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                //            $logger->notice(var_dump($comment));
                //            $logger->notice(var_dump($form));

                return $this->redirectToRoute('blog_show', ['slug' => $post->getSlug()]);
            }
        }

        return $this->render('posts/show.html.twig', [
            'post' => $post,
            'form' => isset($form) ? $form->createView() : null
        ]);
    }
}
