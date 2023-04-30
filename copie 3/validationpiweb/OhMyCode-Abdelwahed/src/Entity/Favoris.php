<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FavorisRepository;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
class Favoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 25)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Produit::class)]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    private ?Service $service = null;
    #[ORM\ManyToOne(targetEntity: User::class)]
private ?User $user = null;

public function getDescription(): ?string
{
    return $this->description;
}

public function setDescription(string $description): self
{
    $this->description = $description;

    return $this;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
    public function setUser(?User $user): self
{
    $this->user = $user;

    return $this;
}
public function getUser(): ?User
{
    return $this->user;
}


}
