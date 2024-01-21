<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CatNom = null;

    #[ORM\Column(length: 255)]
    private ?string $CatType = null;

   

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: SousCategorie::class)]
    private Collection $SousCategorie;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->SousCategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatNom(): ?string
    {
        return $this->CatNom;
    }

    public function setCatNom(string $CatNom): self
    {
        $this->CatNom = $CatNom;

        return $this;
    }

    public function getCatType(): ?string
    {
        return $this->CatType;
    }

    public function setCatType(string $CatType): self
    {
        $this->CatType = $CatType;

        return $this;
    }

    

    /**
     * @return Collection<int, SousCategorie>
     */
    public function getSousCategorie(): Collection
    {
        return $this->SousCategorie;
    }

    public function addSousCategorie(SousCategorie $sousCategorie): self
    {
        if (!$this->SousCategorie->contains($sousCategorie)) {
            $this->SousCategorie->add($sousCategorie);
            $sousCategorie->setCategorie($this);
        }

        return $this;
    }

    public function removeSousCategorie(SousCategorie $sousCategorie): self
    {
        if ($this->SousCategorie->removeElement($sousCategorie)) {
            // set the owning side to null (unless already changed)
            if ($sousCategorie->getCategorie() === $this) {
                $sousCategorie->setCategorie(null);
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
