<?php

namespace App\Entity;

use App\Repository\TipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipRepository::class)]
class Tip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $publishedDate = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $likeNumber = null;

    #[ORM\ManyToOne(inversedBy: 'tips')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'tips')]
    private ?Article $article = null;

    #[ORM\OneToMany(mappedBy: 'tip', targetEntity: TipLike::class)]
    private Collection $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeImmutable
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(\DateTimeImmutable $publishedDate): self
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    public function getLikeNumber(): ?string
    {
        return $this->likeNumber;
    }

    public function setLikeNumber(?string $likeNumber): self
    {
        $this->likeNumber = $likeNumber;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return Collection<int, TipLike>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(TipLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setTip($this);
        }

        return $this;
    }

    public function removeLike(TipLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getTip() === $this) {
                $like->setTip(null);
            }
        }

        return $this;
    }
}
