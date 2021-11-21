<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
#[ApiResource(normalizationContext: ['groups' => ['article_read']])]
class Articles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(["article_read"])]
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(["article_read"])]
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(["article_read"])]
    private $urlToImage;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(["article_read"])]
    private $publishedAt;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(["article_read"])]
    private $externalLink;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="articles", orphanRemoval=true)
     */
    #[Groups(["article_read"])]
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Authors::class, inversedBy="articles", cascade={"persist"})
     */
    #[Groups(["article_read"])]
    private $authors;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="articles")
     */
    #[Groups(["article_read"])]
    private $category;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->authors = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->publishedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrlToImage(): ?string
    {
        return $this->urlToImage;
    }

    public function setUrlToImage(string $urlToImage): self
    {
        $this->urlToImage = $urlToImage;

        return $this;
    }

    public function getPublishedAt(): \DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getExternalLink(): ?string
    {
        return $this->externalLink;
    }

    public function setExternalLink(string $externalLink): self
    {
        $this->externalLink = $externalLink;

        return $this;
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
            $comment->setArticles($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticles() === $this) {
                $comment->setArticles(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Authors $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Authors $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }
}
