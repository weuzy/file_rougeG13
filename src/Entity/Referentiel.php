<?php

namespace App\Entity;

use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $critere_d_evaluation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $critere_d_admission;

    /**
     * @ORM\ManyToMany(targetEntity=GroupesDeCompetences::class, inversedBy="referentiels")
     */
    private $groupeDeCompetence;

    public function __construct()
    {
        $this->groupeDeCompetence = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereDEvaluation(): ?string
    {
        return $this->critere_d_evaluation;
    }

    public function setCritereDEvaluation(string $critere_d_evaluation): self
    {
        $this->critere_d_evaluation = $critere_d_evaluation;

        return $this;
    }

    public function getCritereDAdmission(): ?string
    {
        return $this->critere_d_admission;
    }

    public function setCritereDAdmission(string $critere_d_admission): self
    {
        $this->critere_d_admission = $critere_d_admission;

        return $this;
    }

    /**
     * @return Collection|GroupesDeCompetences[]
     */
    public function getGroupeDeCompetence(): Collection
    {
        return $this->groupeDeCompetence;
    }

    public function addGroupeDeCompetence(GroupesDeCompetences $groupeDeCompetence): self
    {
        if (!$this->groupeDeCompetence->contains($groupeDeCompetence)) {
            $this->groupeDeCompetence[] = $groupeDeCompetence;
        }

        return $this;
    }

    public function removeGroupeDeCompetence(GroupesDeCompetences $groupeDeCompetence): self
    {
        if ($this->groupeDeCompetence->contains($groupeDeCompetence)) {
            $this->groupeDeCompetence->removeElement($groupeDeCompetence);
        }

        return $this;
    }
}
