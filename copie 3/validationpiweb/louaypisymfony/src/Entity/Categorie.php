<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'id_categorie')]
    private ?int $idCategorie = null;
    

    #[Regex(pattern: '/^[a-zA-Z0-9 _&\-\.\,\'\(\)]+$/i', message: 'Seules les lettres, les chiffres et certains symboles sont autorisés.')]    
#[Regex(pattern: '/^[a-zA-Z]+$/i', message: 'Seules les lettres sont autorisées.')]
#[Assert\NotBlank(message:'veillez saisir un nom ')]
 #[Assert\Length(min:3,minMessage:'min 3 charactere')]
#[ORM\Column(length: 150)]
private ?string $nom = null;


#[Assert\NotBlank(message:'veillez saisir un nom ')]
#[Assert\Length(min:3,minMessage:'min 3 charactere')]
#[ORM\Column(length: 150)]
private ?string $description = null;

#[ORM\Column(type: 'blob')]
private $image = null;

#[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
private ?Collection $article = null;

#[ORM\Column(length: 255)]
private ?string $type = null;



public function __construct()
{
    $this->article = new ArrayCollection();
}
public function getIdCategorie(): ?int
{
    return $this->idCategorie ;
}

public function getNom(): ?string
{
    return $this->nom;
}

public function setNom(?string $nom): self
{
    if ($nom === null) {
        // handle null value here, if needed
    }
    
    $this->nom = $nom;
    return $this;
}


public function getDescription(): ?string
{
    return $this->description;
}

public function setDescription(?string $description): self
{
    if ($description === null) {
        // handle null value here, if needed
    }
    
    $this->description = $description;
    return $this;
}

    
  
 /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
            $article->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategorie() === $this) {
                $article->setCategorie(null);
            }
        }

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
    public function __toString()
{
    return $this->nom;
}

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }


}