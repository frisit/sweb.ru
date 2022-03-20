<?php

namespace App\Entity;

use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Comment;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="posts")
 */
class Post
{
    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';

    /**
     * @var Uuid
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $status;

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post")
     */
    private $comments;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="post_categories")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $categories;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private $created_at;


    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $user;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->created_at = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $this->comments = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function addComment(Comment $comment): void
    {
        $comment->setPost($this);

        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }

    public function removeComment(Comment $comment): void
    {
        $this->comments->removeElement($comment);
    }

    public function getComments()
    {
        return $this->comments;
    }

    public static function fromDraft(
        User $user,
        ?string $title = null,
        ?string $body = null,
        ?string $slug = null
    ): Post {
        $post = new self();
        $post->title = $title;
        $post->body = $body;
        $post->slug = $slug;
        $post->user = $user;
        $post->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $post->status = self::DRAFT;

        return $post;
    }

    public static function fromPublished(string $title, string $body, string $slug): Post
    {
        $post = new self();
        $post->title = $title;
        $post->body = $body;
        $post->slug = $slug;
        $post->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $post->publishedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $post->status = self::PUBLISHED;

        return $post;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }




}