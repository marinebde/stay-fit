<?php

namespace App\Entity;

use App\Repository\PartenaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PartenaireRepository::class)]
class Partenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['show_partenaire'])]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    #[Groups(['show_partenaire'])]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups(['show_partenaire'])]
    private ?bool $statut = true;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'partenaires')]
    private Collection $users;

    #[ORM\OneToMany(targetEntity: Structure::class, mappedBy: 'partenaire')]
    private Collection $structures;

    #[ORM\ManyToMany(targetEntity: Module::class, inversedBy: 'partenaires')]
    private Collection $Modules;



    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->structures = new ArrayCollection();
        $this->Modules = new ArrayCollection();
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
        return $this-> nom;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setPartenaires($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPartenaires() === $this) {
                $user->setPartenaires(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
            $structure->setPartenaire($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getPartenaire() === $this) {
                $structure->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->Modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->Modules->contains($module)) {
            $this->Modules->add($module);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        $this->Modules->removeElement($module);

        return $this;
    }

}
