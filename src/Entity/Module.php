<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\ManyToMany(targetEntity: Partenaire::class, mappedBy: 'Modules')]
    private Collection $partenaires;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: StructureModules::class)]
    private Collection $structure;




    public function __construct()
    {
        $this->partenaires = new ArrayCollection();
        $this->structure = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return Collection<int, Partenaire>
     */
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires->add($partenaire);
            $partenaire->addModule($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->removeElement($partenaire)) {
            $partenaire->removeModule($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, StructureModules>
     */
    public function getStructure(): Collection
    {
        return $this->structure;
    }

    public function addStructure(StructureModules $structure): self
    {
        if (!$this->structure->contains($structure)) {
            $this->structure->add($structure);
            $structure->setModule($this);
        }

        return $this;
    }

    public function removeStructure(StructureModules $structure): self
    {
        if ($this->structure->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getModule() === $this) {
                $structure->setModule(null);
            }
        }

        return $this;
    }


}
