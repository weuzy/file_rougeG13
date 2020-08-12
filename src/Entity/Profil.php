<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ArchivageProfilController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 * attributes = {
    * "normalizationContext"={"groups"={"read"}},
    * "denormalizationContext"={"groups"={"write"}},
    *  "security" = "is_granted('ROLE_ADMIN')",
    *  "security_message" = "vous n'avez pas accés à cette ressource",
    *  "pagination_enabled" = true,
    *  "pagination_items_per_page" = 3
 * },
 * collectionOperations = {"post", "get"},
 * itemOperations = {"put","get", "delete_profil" = {
 * "method" = "PUT",
 * "path" = "/profils/{id}/archivages",
 * "controller" = ArchivageProfilController::class
 * }
 * },
 * )
 */
class Profil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "le libellé ne peut pas être vide")
     * @Groups({"read", "write"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     *  @Groups("read")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("read")
     */
    private $archives;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

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
}
