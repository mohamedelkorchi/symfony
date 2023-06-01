<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "LE NOM DU PRODUIT EST OBLIGATOIRE ")]
    #[Assert\Length(min: 3 ,max: 255 , minMessage: "minErrorMessage")]

    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "LE PRIX DU PRODUIT EST OBLIGATOIRE ")]

    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Assert\NotBlank(message: "Choississez une catégorie svp ")]

    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url(message: "L'image doit etre une URL valide  ")]
    #[Assert\NotBlank(message: "L'image DU PRODUIT EST OBLIGATOIRE ")]
    
    
    private ?string $mainPicture = null;
    
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "La description courte est obligatoire ")]
    #[Assert\Length(min: 20, minMessage: "La description doit faire au minimum 20 caractères")]

    private ?string $shortDescription = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: PurchaseItem::class)]
    private Collection $purchaseItems;

    public function __construct()
    {
        $this->purchaseItems = new ArrayCollection();
    }

    // public static function loadValidatorMetadata(ClassMetadata $metadata) {

    //     $metadata->addPropertyConstraints("name", [
    //         new Assert\NotBlank(["message" => "Nom du produit obligatoire"]),
    //         new Assert\Length(["min" => 3,
    //                     "max" => 255,
    //                     "minMessage" => " Minimum 3 caractères !"])
    //     ]);

    //     $metadata->addPropertyConstraint("price", new Assert\NotBlank(["message" => "Prix obligatoire !"]));
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?string $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return Collection<int, PurchaseItem>
     */
    public function getPurchaseItems(): Collection
    {
        return $this->purchaseItems;
    }

    public function addPurchaseItem(PurchaseItem $purchaseItem): self
    {
        if (!$this->purchaseItems->contains($purchaseItem)) {
            $this->purchaseItems->add($purchaseItem);
            $purchaseItem->setProduct($this);
        }

        return $this;
    }

    public function removePurchaseItem(PurchaseItem $purchaseItem): self
    {
        if ($this->purchaseItems->removeElement($purchaseItem)) {
            // set the owning side to null (unless already changed)
            if ($purchaseItem->getProduct() === $this) {
                $purchaseItem->setProduct(null);
            }
        }

        return $this;
    }
}
