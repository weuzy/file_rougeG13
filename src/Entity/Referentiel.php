<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ArchivageReferentielController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *     routePrefix="/",
 *     normalizationContext={"groups"={"referentiel:read"}},
 *   denormalizationContext={"groups"={"referentiel:write"}},
 * attributes= {
 *  "security" = "is_granted('ROLE_ADMIN')",
 *  "security_message" = "vous n'avez pas accés à cette ressource",
 *  "pagination_enabled" = true,
 *  "pagination_items_per_page" = 1
 * },
 *  collectionOperations = {
 *      "get",
 *      "add_referentiel" = {
 *              "method" = "POST",
 *              "route_name" = "add_referentiel",
 *       }
 *  },
 *
 * itemOperations = {
 *     "put",
 *     "get",
 *     "delete_referentiel" = {
 *         "method" = "PUT",
 *         "path" = "/referentiels/{id}/archivages",
 *         "controller" = ArchivageReferentielController::class
 *      }
 * }
 *
 *)
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
     * @Assert\NotBlank(message="Don't fou de ma gueule, na am dara ")
     * @Groups({"referentiel:read", "referentiel:write"})
     */

    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Don't fou de ma gueule, na am dara ")
     * @Groups({"referentiel:read", "referentiel:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read", "referentiel:write"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read", "referentiel:write"})
     */
    private $critere_d_evaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read", "referentiel:write"})
     */
    private $critere_d_admission;

    /** travail
     * @ORM\ManyToMany(targetEntity=GroupesDeCompetences::class, inversedBy="referentiels")
     * @Groups({"referentiel:read", "referentiel:write"})
     * @ApiSubresource
     */
    private $groupeDeCompetence;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"referentiel:write"})
     */
    private $archive;

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

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(?bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
