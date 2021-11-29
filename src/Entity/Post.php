<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Comment;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Length(min=10, max=255)
     */
    private $title;


    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $body;


    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $slug;


    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     * */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     * */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     * */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeInterface $created_at
     */
    public function setCreatedAt(\DateTimeInterface $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function addComment(Comment $comment): void
    {
        $comment->setPost($this);

        if(!$this->comments->contains($comment)) {
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
}