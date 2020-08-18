<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Groupe;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\ArchivageGroupe;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     routePrefix="/",
 *     attributes={
 *          "normalization_context"={"groups"={"groupe:read"}},
 *          "denormalization_context"={"groups"={"groupe:write"}},
 *          "security"="is_granted('ROLE_FORMATEUR')",
 *          "security_message"="Vous n'avez pas access à cette Ressource",
 *          "pagination_enabled" = true,
 *          "pagination_items_per_page" = 1
 *      },
 *     normalizationContext={"groups"={"essei:read"}},
 *     collectionOperations={
 *                  "get_groupe"={
 *                      "method"="GET",
 *                      "route_name"="groupe_liste"
 *                  },
 *                 "add_groupe"={
 *                      "method"="POST",
 *                      "route_name"="groupe_add",
 *                   }
 *     },
 *     itemOperations={
 *              "get","put",
 *              "delete_promo" = {
 *"method" = "PUT",
 *"path" = "/groupes/{id}/archivages",
 *"controller" = ArchivageGroupe::class
 * }
 *     }
 * )
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $periode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    /**
     * @ORM\Column(type="date", nullable=false)
     * @Groups({"groupe:write"})
     */
    private $date_creation;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="groupe")
     * @ApiSubresource
     * @Groups({"groupe:write","groupe:read"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="groupes")
     */
    private $formateur;

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
        $this->formateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->setGroupe($this);
        }

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(string $periode): self
    {
        $this->periode = $periode;

        return $this;
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

    public function getPromotion(): ?Promo
    {
        return $this->promotion;
    }

    public function setPromotion(?Promo $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(?\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(User $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(User $formateur): self
    {
        if ($this->formateur->contains($formateur)) {
            $this->formateur->removeElement($formateur);
        }

        return $this;
    }

}
