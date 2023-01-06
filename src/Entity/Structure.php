<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StructureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['show_structure'])]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    #[Groups(['show_structure'])]
    private ?string $nom = null;

    #[ORM\Column(length: 360)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $code_postal = null;

    #[ORM\Column(length: 80)]
    private ?string $ville = null;

    #[ORM\Column]
    #[Groups(['show_structure'])]
    private ?bool $statut = null;

    #[ORM\Column(length: 80)]
    private ?string $nom_gerant = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'structures')]
    private Collection $users;

    #[ORM\ManyToOne(targetEntity: Partenaire::class, inversedBy: 'structures')]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Partenaire $partenaire = null;

    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: StructureModules::class)]
    private Collection $modules;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->modules = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

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

    public function getNomGerant(): ?string
    {
        return $this->nom_gerant;
    }

    public function setNomGerant(string $nom_gerant): self
    {
        $this->nom_gerant = $nom_gerant;

        return $this;
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
            $user->setStructures($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStructures() === $this) {
                $user->setStructures(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this-> nom;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    /**
     * @return Collection<int, StructureModules>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(StructureModules $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->setStructure($this);
        }

        return $this;
    }

    public function removeModule(StructureModules $module): self
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getStructure() === $this) {
                $module->setStructure(null);
                $module->setIsActive(false);
                $module->setModule(null);
            }
        }

        return $this;
    }

}
