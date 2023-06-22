<?php

namespace App\Entity;

use App\Repository\TipLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipLikeRepository::class)]
class TipLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    private ?Tip $tip = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTip(): ?Tip
    {
        return $this->tip;
    }

    public function setTip(?Tip $tip): self
    {
        $this->tip = $tip;

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
}
