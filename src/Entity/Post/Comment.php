<?php

declare(strict_types=1);

namespace App\Entity\Post;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Post\Post;
use App\Entity\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="comment")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    public $comment;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="comments")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $post;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $user;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @param string $content
     * @param User $user
     * @param Post $post
     *
     * @return Comment
     */
    public static function create(string $content, User $user, Post $post): Comment
    {
        $comment = new self();
        $comment->comment = $content;
        $comment->post = $post;
        $comment->user = $user;

        return $comment;
    }

    /**
     * @return string| null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}


