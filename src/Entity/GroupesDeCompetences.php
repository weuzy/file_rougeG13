<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\ArchivageGroupesDeCompetences;
use App\Repository\GroupesDeCompetencesRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupesDeCompetencesRepository::class)
 * @ApiResource(
 * attributes= {
        *"normalizationContext" = {"groups":"read"},
        *"denormalizationContext" = {"groups":"write"},
        *"security" = "is_granted('ROLE_ADMIN')",
        *"security_message" = "vous n'avez pas accés à cette ressource",
        *"pagination_enabled" = true,
        *"pagination_items_per_page" = 3
    *},
 * collectionOperations = {"get", 
 * "add_groupeComp" = {
        *"method" = "POST",
        *"path" = "/groupesDeCompetences",
        *"route_name" = "add_groupeComp"
    * }
 * },
 * itemOperations = {"put", "get", "delete_groupesDeCompetences" = {
        * "method" = "PUT",
        * "path" = "/groupes_de_competences/{id}/archivages",
        * "controller" = ArchivageGroupesDeCompetences::class
    * }
 * }
 * )
 */
class GroupesDeCompetences
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
     * @Assert\NotBlank(message = "le libelle ne peut pas être vide")
     * @Groups({"read", "write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "le descriptif ne peut pas être vide")
     * @Groups({"read", "write"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, mappedBy="groupe_de_competences")
     * @ApiSubresource
     * @Assert\NotBlank(message = "les compétences ne peuvent pas être vide")
     * @Groups({"read", "write"})
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="groupe_de_competences")
     * @Groups({"read"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeDeCompetence")
     * @Groups({"read"})
     */
    private $referentiels;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read"})
     */
    private $archives;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Competences[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
            $competence->removeGroupeDeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeGroupeDeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->contains($referentiel)) {
            $this->referentiels->removeElement($referentiel);
            $referentiel->removeGroupeDeCompetence($this);
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
