<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    

    #[ORM\ManyToOne(inversedBy: 'Produit')]
    private ?SousCategorie $sousCategorie = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: SeCompose::class)]
    private Collection $seComposes;

    public function __construct()
    {
        $this->seComposes = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, SeCompose>
     */
    public function getSeComposes(): Collection
    {
        return $this->seComposes;
    }

    public function addSeCompose(SeCompose $seCompose): self
    {
        if (!$this->seComposes->contains($seCompose)) {
            $this->seComposes->add($seCompose);
            $seCompose->setProduit($this);
        }

        return $this;
    }

    public function removeSeCompose(SeCompose $seCompose): self
    {
        if ($this->seComposes->removeElement($seCompose)) {
            // set the owning side to null (unless already changed)
            if ($seCompose->getProduit() === $this) {
                $seCompose->setProduit(null);
            }
        }

        return $this;
    }
}
