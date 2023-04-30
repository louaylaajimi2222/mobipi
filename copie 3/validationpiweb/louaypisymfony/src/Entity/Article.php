<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: "article")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discriminator", type: "string")]
#[ORM\DiscriminatorMap([
    "article" => Article::class,
    "produit" => Produit::class,
    "service" => Service::class,
])]
abstract class   Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $idArticle = null;
  

    #[ORM\Column(length: 25)]
    private ?string $description = null;
   

    #[ORM\Column(length: 25)]
    private ?string $typeArticle = null;
    

    #[ORM\Column(type: 'integer')]
    private ?int $estimation = null;

    #[ORM\Column(type: 'blob')]
    private $image = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateAjout = null;


    #[ORM\Column(length: 25)]
    private ?string $nom= null;
   
    #[ORM\Column(length: 25)]
    private ?string $souscategorie= null;
   

    
   
  
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id')]
    private ?User $user = null;
     
    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: 'id_categorie', referencedColumnName: 'id_categorie')]
    private ?Categorie $categorie = null;

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTypeArticle(): ?string
    {
        return $this->typeArticle;
    }

    public function setTypeArticle(string $typeArticle): self
    {
        $this->typeArticle = $typeArticle;

        return $this;
    }

    public function getEstimation(): ?int
    {
        return $this->estimation;
    }

    public function setEstimation(int $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    
    

    public function getSousCategorie() {
        return $this->souscategorie;
    }

    // Setter
    public function setSousCategorie($souscategorie) {
        $this->souscategorie = $souscategorie;
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }





}