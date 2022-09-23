<?php

namespace App\Entity;

use App\Repository\PartenaireModuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartenaireModuleRepository::class)]
class PartenaireModule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $is_active = true;

    #[ORM\ManyToOne(inversedBy: 'partenaireModules')]
    private ?Partenaire $Partenaires = null;

    #[ORM\ManyToOne(inversedBy: 'partenaireModules')]
    private ?Module $Modules = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getPartenaires(): ?Partenaire
    {
        return $this->Partenaires;
    }

    public function setPartenaires(?Partenaire $Partenaires): self
    {
        $this->Partenaires = $Partenaires;

        return $this;
    }

    public function getModules(): ?Module
    {
        return $this->Modules;
    }

    public function setModules(?Module $Modules): self
    {
        $this->Modules = $Modules;

        return $this;
    }
}
