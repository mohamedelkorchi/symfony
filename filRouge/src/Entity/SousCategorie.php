<?php

namespace App\Entity;

use App\Repository\SousCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousCategorieRepository::class)]
class SousCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $SousCatNom = null;

    #[ORM\Column(length: 255)]
    private ?string $SousCatType = null;

    
    #[ORM\ManyToOne(inversedBy: 'SousCategorie')]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Produit::class)]
    private Collection $Produit;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->Produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSousCatNom(): ?string
    {
        return $this->SousCatNom;
    }

    public function setSousCatNom(string $SousCatNom): self
    {
        $this->SousCatNom = $SousCatNom;

        return $this;
    }

    public function getSousCatType(): ?string
    {
        return $this->SousCatType;
    }

    public function setSousCatType(string $SousCatType): self
    {
        $this->SousCatType = $SousCatType;

        return $this;
    }


    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduit(): Collection
    {
        return $this->Produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->Produit->contains($produit)) {
            $this->Produit->add($produit);
            $produit->setSousCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->Produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getSousCategorie() === $this) {
                $produit->setSousCategorie(null);
            }
        }

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
}
