<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;
use App\Controller\ArchivageUser;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields = {"email", "username"},
 *  message = "le nom d'utilisateur ou l'email est déjà utilisé, veuillez choisir un autre!"
 * )
 * @ApiResource(
    *normalizationContext = {"groups":"user:read"},
    *denormalizationContext = {"groups":"user:write"},
    * attributes = {
        *"security" = "is_granted('ROLE_ADMIN')",
        *"security_message" = "vous n'avez pas accés à cette ressource",
        *"pagination_enabled" = true,
        *"pagination_items_per_page" = 3
    *},
    *collectionOperations = {"get", 
    * "add_user" = {
        *"method" = "POST",
        *"path" = "/users",
        *"route_name" = "add_user"
    * }
*},
    *itemOperations = {"put","get", "delete_user" = {
    *"method" = "PUT",
    *"path" = "/users/{id}/archivages",
    *"controller" = ArchivageUser::class
    * }
 * }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message=" Ça ne doit pas etre vide")
     * @Groups({"user:read", "user:write"})
     */
    private $username;

    
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le password est obligatoire")
     * @Groups({"user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank(message=" le prénom ne peut pas etre vide")
     * @Assert\Regex(
     *  pattern = "/^[A-Z][a-z]+$/",
     *  message = "le prénom commence par une lettre majuscule"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank(message=" le nom ne peut pas etre vide")
     * @Assert\Regex(
     *  pattern = "/^[A-Z]+$/",
     *  message = " le nom est en majuscule"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank(message=" le téléphone ne peut pas etre vide")
     * @Assert\Regex(
     *  pattern = "/^7[7|6|8|0][0-9]{7}$/",
     *  message = "le numero doit être orange, free ou expresso"
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank(message=" le genre ne peut pas etre vide")
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank(message=" l'adresse email ne peut pas etre vide")
     */
    private $email;



    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="user")
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank(message=" le profil ne peut pas etre vide")
     */
    private $profil;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user:read"})
     */
    private $archives;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"user:write"})
     */
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this -> profil -> getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
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

    

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getArchives(): ?bool
    {
        return $this->archives;
    }

    public function setArchives(bool $archives): self
    {
        $this->archives = $archives;

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
}
