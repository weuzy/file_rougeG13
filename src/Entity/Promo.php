<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\ArchivagePromo;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     routePrefix="/",
 *     attributes={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *          "security_message"="Vous n'avez pas access à cette Ressource",
 *          "normalization_context"={"groups"={"promo:read"}},
 *          "denormalization_context"={"groups"={"promo:write"}}
 *      },
 *     collectionOperations={
 *                  "get_promo"={
 *                      "method"="GET",
 *                      "route_name"="promo_liste"
 *                  },
 *                 "add_promo"={
 *                      "method"="POST",
 *                      "route_name"="promo_add",
 *                   }
 *     },
 *     itemOperations={
 *              "get","put",
 *              "delete_promo" = {
 *                  "method" = "PUT",
 *                  "path" = "/promos/{id}/archivages",
 *                   "controller" = ArchivagePromo::class
 * }
 *     }
 * )
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @UniqueEntity(
 *     fields={"libelle"},
 *     message = "Ce promo a deja existé"
 * )
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"promo:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Le libelle de la promo ne peut etre vide")
     * @Groups({"promo:read","promo:write","groupe:read","groupe:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo:read","promo:write","groupe:read","groupe:read"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"promo:write"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"promo:write"})
     */
    private $archive;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promotion", orphanRemoval=true)
     * @Assert\NotBlank(message = "met le groupe principal par defaut")
     * @ApiSubresource
     * @Groups({"promo:read","groupe:read"})
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="promos")
     * @Groups({"promo:read","promo:write"})
     * @Assert\NotBlank(message = "ajoute un referentiel")
     * @ApiSubresource
     */
    private $referentiel;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
        $this->referentiel = new ArrayCollection();
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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromotion($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getPromotion() === $this) {
                $groupe->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiel(): Collection
    {
        return $this->referentiel;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiel->contains($referentiel)) {
            $this->referentiel[] = $referentiel;
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiel->contains($referentiel)) {
            $this->referentiel->removeElement($referentiel);
        }

        return $this;
    }
}
