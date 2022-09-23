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

    #[ORM\OneToMany(mappedBy: 'Modules', targetEntity: PartenaireModule::class)]
    private Collection $partenaireModules;

    public function __construct()
    {
        $this->partenaireModules = new ArrayCollection();
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

    /**
     * @return Collection<int, PartenaireModule>
     */
    public function getPartenaireModules(): Collection
    {
        return $this->partenaireModules;
    }

    public function addPartenaireModule(PartenaireModule $partenaireModule): self
    {
        if (!$this->partenaireModules->contains($partenaireModule)) {
            $this->partenaireModules->add($partenaireModule);
            $partenaireModule->setModules($this);
        }

        return $this;
    }

    public function removePartenaireModule(PartenaireModule $partenaireModule): self
    {
        if ($this->partenaireModules->removeElement($partenaireModule)) {
            // set the owning side to null (unless already changed)
            if ($partenaireModule->getModules() === $this) {
                $partenaireModule->setModules(null);
            }
        }

        return $this;
    }
}
