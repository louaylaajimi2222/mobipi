<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
#[ORM\DiscriminatorMap([
    "article" => Article::class,
    "produit" => Produit::class,
])]
class Produit extends Article
{
    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column]
    private ?int $poid = null;

    #[ORM\Column(length: 255)]
    private ?string $dureedevie = null;

    public function __construct()
    {
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPoid(): ?int
    {
        return $this->poid;
    }

    public function setPoid(int $poid): self
    {
        $this->poid = $poid;

        return $this;
    }

    public function getDureeDeVie(): ?string
    {
        return $this->dureedevie;
    }

    public function setDureeDeVie(string $duree_de_vie): self
    {
        $this->dureedevie = $duree_de_vie;

        return $this;
    }
}
    
