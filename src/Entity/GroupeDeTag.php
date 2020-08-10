<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\ArchivageGroupeDeTag;
use App\Repository\GroupeDeTagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupeDeTagRepository::class)
 * @ApiResource(
 * attributes = {
        *"normalizationContext" = {"groups":"read"},
        *"denormalizationContext" = {"groups":"write"},
        *"security" = "is_granted('ROLE_ADMIN')",
        *"security_message" = "vous n'avez pas accés à cette ressource",
    *},
    *collectionOperations = {"post", "get"},
    *itemOperations = {"put", "get", "delete_groupeDeTag" = {
        *"method" = "PUT",
        *"path" = "/groupe_de_tags/{id}/archivages",
        *"controller" = ArchivageGroupeDeTag::class
      *}
    *}
 * )
 */
class GroupeDeTag
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
     * @Assert\NotBlank(message = "le libellé ne peut pas être vide")
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeDeTags")
     * @Groups({"read", "write"})
     * @Assert\NotBlank(message = "le tag ne peut pas être vide")
     */
    private $tags;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archives;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
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
