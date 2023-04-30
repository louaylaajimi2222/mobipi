<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
 class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $sexe = null;

   

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_deblockage = null;

    #[ORM\Column]
    private ?int $is_block =0 ;

    #[ORM\Column]
    private ?int $duree = 0;
    // ...  
    #[ORM\Column(length: 255, nullable: true)]
    private $reset_token;
    
    #[ORM\Column(length: 255)]
       private ?string $photo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $naissance = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;
     #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
private ?Collection $article = null;
#[ORM\OneToMany(mappedBy: 'user', targetEntity: Favoris::class)]
private ?Collection $favoris = null;




//     public function getFavoris(): Collection
//     {
//         return $this->favoris;
//     }
//     public function addFavori(Favoris $favori): self
//     {
//         if (!$this->favoris->contains($favori)) {
//             $this->favoris[] = $favori;
//             $favori->setUser($this);
//         }
    
//         return $this;
//     }
    
//     public function removeFavori(Favoris $favori): self
//     {
//         if ($this->favoris->removeElement($favori)) {
//             // set the owning side to null (unless already changed)
//             if ($favori->getUser() === $this) {
//                 $favori->setUser(null);
//             }
//         }
    
//         return $this;
//     }
    

//   #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Reclamation::class, orphanRemoval: true)]
//     private Collection $sent;

//     #[ORM\OneToMany(mappedBy: 'recipient', targetEntity: Reclamation::class, orphanRemoval: true)]
//     private Collection $received;

    public function __construct()
    {
         $this->article = new ArrayCollection();
        //   $this->sent = new ArrayCollection();
        // $this->received = new ArrayCollection();
    }
    /**
* @return Collection<int, Article>
*/
public function getArticle(): Collection
{
   return $this->article;
}

  public function setPhoto(?string $photo): self
{
    $this->photo = $photo;

    return $this;
}
public function getPhoto(): ?string
{
    return $this->photo;
}
public function __toString()
{
    // Return the desired string representation of the User object
    return $this->getName(); // Replace with the appropriate property or method that represents the name of the user
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
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

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }


public function getDateDeblockage(): ?\DateTimeInterface
{
    return $this->date_deblockage;
}

public function setDateDeblockage(?\DateTimeInterface $date_deblockage): self
{
    $this->date_deblockage = $date_deblockage;

    return $this;
}

public function getIsBlock(): ?int
{
    $is_block = $this->is_block;
        
        $is_block = 0;    

    return $is_block;

}

public function setIsBlock(int $is_block): self
{
    $this->is_block = $is_block;

    return $this;
}

public function getDuree(): ?int
{
     $duree =  $this->duree;
     $duree = 0;
    return  $duree;
}

public function setDuree(int $duree): self
{
    $this->duree = $duree;

    return $this;
}

 /**
     * @return mixed
     */
    public function getResetToken()
    {
        return $this->reset_token;
    }

    /**
     * @param mixed $reset_token
     */
    public function setResetToken($reset_token): void
    {
        $this->reset_token = $reset_token;
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
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
// /**
//  * @return Collection<int, Reclamation>
//  */
// public function getReceived(): Collection
// {
//     return $this->received;
// }

// public function addReceived(Reclamation $received): self
// {
//     if (!$this->received->contains($received)) {
//         $this->received->add($received);
//         $received->setRecipient($this);
//     }

//     return $this;
// }

// public function removeReceived(Reclamation $received): self
// {
//     if ($this->received->removeElement($received)) {
//         // set the owning side to null (unless already changed)
//         if ($received->getRecipient() === $this) {
//             $received->setRecipient(null);
//         }
//     }

//     return $this;
// }

// /**
//  * @return Collection<int, Reclamation>
//  */
// public function getSent(): Collection
// {
//     return $this->sent;
// }

// public function addSent(Reclamation $sent): self
// {
//     if (!$this->sent->contains($sent)) {
//         $this->sent->add($sent);
//         $sent->setSender($this);
//     }

//     return $this;
// }

// public function removeSent(Reclamation $sent): self
// {
//     if ($this->sent->removeElement($sent)) {
//         // set the owning side to null (unless already changed)
//         if ($sent->getSender() === $this) {
//             $sent->setSender(null);
//         }
//     }

//     return $this;
// }


}
