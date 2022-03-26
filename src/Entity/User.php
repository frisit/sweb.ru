<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Post\Comment;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity(fields={"email"}, message="Увас уже есть аккаунт")
 * */
class User implements UserInterface
{
    public const ROLE_VIEWER = 'viewer';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     * */
    private $email = '';

    /**
     * @ORM\Column(type="string")
     * */
    private $password = '';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * */
    private $plainPassword = '';

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     * */
    private $roles = [];

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * */
    private $confirmationCode;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * */
    private $enabled;

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     */
    private $comments;


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = [self::ROLE_USER];
        $this->enabled = false;
        $this->comments = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    /**
     * @param $roles
     *
     * @return $this
     */
    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string|void|null
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return $this
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationCode(): string
    {
        return $this->confirmationCode;
    }

    /**
     * @param string $confirmationCode
     *
     * @return User
     */
    public function setConfirmationCode(string $confirmationCode): self
    {
        $this->confirmationCode = $confirmationCode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return User
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }


}