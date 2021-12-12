<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 */
#[ApiResource(
    collectionOperations: ['POST'],
    itemOperations: [
        'GET',
        'DELETE' => ["security" => "is_granted('ROLE_ADMIN')"]
        ],
    denormalizationContext: ['groups' => ['comments_write']],
    formats: ['json'],
    normalizationContext: ['groups' => ['comments_read']],

)]
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['article_read', 'comments_read'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['article_read', 'comments_read', 'comments_write'])]
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['article_read', 'comments_read'])]
    private $postedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Articles::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['article_read', 'comments_read', 'comments_write'])]
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['article_read', 'comments_read', 'comments_write'])]
    private $users;


    public function __construct()
    {
        $this->postedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeInterface $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(?Articles $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }
}
