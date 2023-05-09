<?php

namespace App\Entity;

use App\Repository\TravelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TravelRepository::class)]
class Travel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $picture = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?int $travelerNumber = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'travels')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'travel', targetEntity: Article::class)]
    private Collection $articles;

    #[ORM\ManyToMany(targetEntity: Destination::class, inversedBy: 'travel')]
    private Collection $destinations;

    #[ORM\ManyToMany(targetEntity: Traveler::class, inversedBy: 'travel', cascade: ["persist"])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private Collection $travelers;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->destinations = new ArrayCollection();
        $this->travelers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getTravelerNumber(): ?int
    {
        return $this->travelerNumber;
    }

    public function setTravelerNumber(int $travelerNumber): self
    {
        $this->travelerNumber = $travelerNumber;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addTravel($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTravel($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setTravel($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getTravel() === $this) {
                $article->setTravel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Destination>
     */
    public function getDestinations(): Collection
    {
        return $this->destinations;
    }

    public function addDestination(Destination $destination): self
    {
        if (!$this->destinations->contains($destination)) {
            $this->destinations->add($destination);
        }

        return $this;
    }

    public function removeDestination(Destination $destination): self
    {
        $this->destinations->removeElement($destination);

        return $this;
    }

    /**
     * @return Collection<int, Traveler>
     */
    public function getTravelers(): Collection
    {
        return $this->travelers;
    }

    public function addTraveler(Traveler $traveler): self
    {
        if (!$this->travelers->contains($traveler)) {
            $this->travelers->add($traveler);
        }

        return $this;
    }

    public function removeTraveler(Traveler $traveler): self
    {
        $this->travelers->removeElement($traveler);

        return $this;
    }
}
