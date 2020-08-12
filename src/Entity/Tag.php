<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupesDeCompetences::class, inversedBy="tags")
     */
    private $groupe_de_competences;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeTag::class, mappedBy="tags")
     */
    private $groupeDeTags;

    public function __construct()
    {
        $this->groupe_de_competences = new ArrayCollection();
        $this->groupeDeTags = new ArrayCollection();
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
     * @return Collection|GroupesDeCompetences[]
     */
    public function getGroupeDeCompetences(): Collection
    {
        return $this->groupe_de_competences;
    }

    public function addGroupeDeCompetence(GroupesDeCompetences $groupeDeCompetence): self
    {
        if (!$this->groupe_de_competences->contains($groupeDeCompetence)) {
            $this->groupe_de_competences[] = $groupeDeCompetence;
        }

        return $this;
    }

    public function removeGroupeDeCompetence(GroupesDeCompetences $groupeDeCompetence): self
    {
        if ($this->groupe_de_competences->contains($groupeDeCompetence)) {
            $this->groupe_de_competences->removeElement($groupeDeCompetence);
        }

        return $this;
    }

    /**
     * @return Collection|GroupeDeTag[]
     */
    public function getGroupeDeTags(): Collection
    {
        return $this->groupeDeTags;
    }

    public function addGroupeDeTag(GroupeDeTag $groupeDeTag): self
    {
        if (!$this->groupeDeTags->contains($groupeDeTag)) {
            $this->groupeDeTags[] = $groupeDeTag;
            $groupeDeTag->addTag($this);
        }

        return $this;
    }

    public function removeGroupeDeTag(GroupeDeTag $groupeDeTag): self
    {
        if ($this->groupeDeTags->contains($groupeDeTag)) {
            $this->groupeDeTags->removeElement($groupeDeTag);
            $groupeDeTag->removeTag($this);
        }

        return $this;
    }
}
