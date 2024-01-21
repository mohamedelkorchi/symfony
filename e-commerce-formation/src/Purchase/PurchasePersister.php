<?php 

namespace App\Purchase;

use App\cart\CartService;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use DateTimeImmutable;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PurchasePersister 
{
    protected $security;
    protected $cartservice;
    protected $em;

    public function __construct(Security $security, CartService $cartservice, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->cartservice = $cartservice;
        $this->em = $em;
    }

    public function storePurchase(Purchase $purchase)
    {
         //6. Lier avec l'utilisateur connecté 

         $purchase->setUser($this->security->getUser())
         ->setPurchasedAt(new DateTimeImmutable())
         ->setTotal($this->cartservice->getTotal());

 $this->em->persist($purchase);

//7. Lier avec les produits qui sont dans le panier (CartService)


 foreach($this->cartservice->getDetailedCartItems() as $cartItem) {
     $purchaseItem = new PurchaseItem;
     $purchaseItem->setPurchase($purchase)
                 ->setProduct($cartItem->product)
                 ->setProductName($cartItem->product->getName())
                 ->setQuantity($cartItem->qty)
                 ->setTotal($cartItem->getTotal())
                 ->setProductPrice($cartItem->product->getPrice());


     $this->em->persist($purchaseItem);
 }


//8. Enregistrer la commance (entitymanagerinterface)

 $this->em->flush();
    }
}