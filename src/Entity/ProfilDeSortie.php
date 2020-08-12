<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilDeSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\ArchivageProfilDeSortieController;

/**
 * @ORM\Entity(repositoryClass=ProfilDeSortieRepository::class)
 * @ApiResource(
 * attributes = {
    * "normalizationContext" = {"groups":"read"},
    * "denormalizationContext" = {"groups":"write"},
    * "security" = "is_granted('ROLE_ADMIN')",
    * "security_message" = "vous n'avez pas accés à cette ressource",
    * "pagination_enabled" = true,
    * "pagination_items_per_page" = 3
 * },
 * collectionOperations = {"post", "get"},
 * itemOperations = {"put", "get", "delete_profil_de_sortie"= {
 * "method" = "PUT",
 * "path" = "/profil_de_sorties/{id}/archivages",
 * "controller" = ArchivageProfilDeSortieController::class
 * }
 * }
 * )
 */
class ProfilDeSortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     * @Assert\NotBlank(message="ce champs est obligatoire")
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    private $archives;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profil_de_sortie")
     * @Groups({"read"})
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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

    public function getArchives(): ?bool
    {
        return $this->archives;
    }

    public function setArchives(bool $archives): self
    {
        $this->archives = $archives;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setProfilDeSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilDeSortie() === $this) {
                $apprenant->setProfilDeSortie(null);
            }
        }

        return $this;
    }
}
