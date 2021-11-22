<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity("email", message="Un compte existe déjà avec cette email")
 */
#[ApiResource]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(message="Cette adresse email n'est pas valide.")
     * @Assert\NotBlank(message="Vous devez remplir ce champ.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez remplir ce champ.")
     * @Assert\Regex(pattern="/^[.A-zÀ-ÿ-]+$/", message="Les lettres et les tirets sont seulement autorisés.")
     * @Assert\Length(min=3, minMessage="Le champ doit contenir au minimum {{ limit }} caractères.",
     *     max=255, maxMessage="Le champ doit contenir au maximum {{ limit }} caractères.")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez remplir ce champ.")
     * @Assert\Regex(pattern="/^[.A-zÀ-ÿ-]+$/", message="Les lettres et les tirets sont seulement autorisés.")
     * @Assert\Length(min=3, minMessage="Le champ doit contenir au minimum {{ limit }} caractères.",
     *     max=255, maxMessage="Le champ doit contenir au maximum {{ limit }} caractères.")
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Vous devez remplir ce champ.")
     * @Assert\GreaterThan(value="-120 years", message="Vous ne pouvez pas avoir plus de 120 ans.")
     * @Assert\LessThan(value="-18 years", message="Vous devez être majeur pour vous inscrire sur ce site.")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez remplir ce champ.")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="users", orphanRemoval=true)
     */
    private $comments;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUsers($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUsers() === $this) {
                $comment->setUsers(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    private function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
