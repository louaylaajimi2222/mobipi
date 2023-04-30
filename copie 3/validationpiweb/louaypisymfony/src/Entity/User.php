<?php

namespace App\Entity;

use App\Entity\Article;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]



class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue ]
    #[ORM\Column]
private ?int $id = null;


#[ORM\Column]
private array $roles = [];



#[ORM\Column(length: 25)]
    private ?string  $email = null;


    #[ORM\Column(length: 25)]
    private ?string  $password = null;


    #[ORM\Column(length: 25)]
    private ?string $name = null;


    
    #[ORM\Column(name: "PhoneNumber", type: 'integer')]
    private ?int $phoneNumber = null;
    
    #[ORM\Column(length: 25)]
    private ?string  $sexe = null;
    

    #[ORM\Column(type: 'blob')]
    private $photo= null;
    
    #[ORM\Column(name: "age", type: 'integer')]
    private ?int $age = null;

    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dateDeblockage = null;
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $naissance = null;
    
    #[ORM\Column(name: "isblock", type: 'integer')]
    private ?int $isblock = null;
    #[ORM\Column(name: "duree", type: 'integer')]
    private ?int $duree = null;
    #[ORM\Column(length: 25)]
    private ?string  $reset_token = null;

   
    
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
private ?Collection $article = null;
    public function __construct()
{
    $this->article = new ArrayCollection();
}
    
   
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
    
    
   
    
    public function getDateDeblockage(): ?\DateTimeInterface
    {
        return $this->dateDeblockage;
    }
    
    public function setDateDeblockage(?\DateTimeInterface $dateDeblockage): self
    {
        $this->dateDeblockage = $dateDeblockage;
    
        return $this;
    }
    
    
    
   
    

    public function getIdUser(): ?int
    {
        return $this->id;
    }

    public function setIdUser(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->name;
    }

    public function setUsername(?string $username): self
    {
        $this->name = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(?string $email): self
    {
        $this->email = $email;
    
        return $this;
    }
    
    public function getPhoto()
    {
        return $this->photo;
    }
    
    public function setPhoto($photo): self
    {
        $this->photo = $photo;
    
        return $this;
    }
    
   
    
    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }
    
    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }
    
    public function getSexe(): ?string
    {
        return $this->sexe;
    }
    
    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;
    
        return $this;
    }
    public function __toString(): string
{
    return $this->name ?? '';
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
       $article->setUser($this);
   }

   return $this;
}

public function removeArticle(Article $article): self
{
   if ($this->article->removeElement($article)) {
       // set the owning side to null (unless already changed)
       if ($article->getUser() === $this) {
           $article->setUser(null);
       }
   }

   return $this;
}

public function getId(): ?int
{
    return $this->id;
}

public function getName(): ?string
{
    return $this->name;
}

public function setName(string $name): self
{
    $this->name = $name;

    return $this;
}

public function getAge(): ?int
{
    return $this->age;
}

public function setAge(int $age): self
{
    $this->age = $age;

    return $this;
}

public function getNaissance(): ?\DateTimeInterface
{
    return $this->naissance;
}

public function setNaissance(?\DateTimeInterface $naissance): self
{
    $this->naissance = $naissance;

    return $this;
}

public function getIsblock(): ?int
{
    return $this->isblock;
}

public function setIsblock(int $isblock): self
{
    $this->isblock = $isblock;

    return $this;
}

public function getDuree(): ?int
{
    return $this->duree;
}

public function setDuree(int $duree): self
{
    $this->duree = $duree;

    return $this;
}

public function getResetToken(): ?string
{
    return $this->reset_token;
}

public function setResetToken(string $reset_token): self
{
    $this->reset_token = $reset_token;

    return $this;
}



}