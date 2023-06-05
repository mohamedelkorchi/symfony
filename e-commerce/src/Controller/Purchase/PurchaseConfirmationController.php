<?php 

namespace App\Controller\Purchase;

use DateTime;
use DateTimeImmutable;
use App\Entity\Purchase;
use App\cart\CartService;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class PurchaseConfirmationController extends AbstractController
{
    
    
   
    protected $cartService;
    protected $em;

    public function __construct( CartService $cartService, EntityManagerInterface $em )
    {
        $this->em = $em;
      
      
      
        $this->cartService = $cartService;
    }

    #[Route("/purchase/confirm", name:"purchase_confirm")]
    #[IsGranted("ROLE_USER", message:"Vous devez etre connecté pour confirmer une commande ")]
    
    public function confirm(Request $request){

    //1. lire les données du formulaire 
    // formfactoryinterface / request 

        $form = $this->createForm(CartConfirmationType::class);
        
        $form->handleRequest($request);

    //2. Si le formulaire n'a pas été soumis : oust

        if(!$form->isSubmitted()){

            $this->addFlash("warning","Vous devez remplir le formulaire de confirmation");

            return $this->redirectToRoute("cart_show");
          
        }

    //3. Si je ne suis pas connecté : oust (Security)

        $user = $this->getUser();

        // if(!$user){
        //     throw new AccessDeniedException("Vous devez etre connecté pour confirmer une commande ");
        // }

    //4. Si il n'y a pas de produits dans mon panier : oust (cartservice)
        
        $cartItems = $this->cartService->getDetailedCartItems();

        if(count($cartItems) === 0){
            $this->addFlash("warning","Vous ne pouvez confirmer une commande avec un panier vide !");

            return $this->redirectToRoute("cart_show");
        }

    //5. Creer une Purchase

        /** @var Purchase */  // pour avoir l'auto-completion

        $purchase = $form->getData();

    //6. Lier avec l'utilisateur connecté 

        $purchase->setUser($user)
                ->setPurchasedAt(new DateTimeImmutable())
                ->setTotal($this->cartService->getTotal());

        $this->em->persist($purchase);

    //7. Lier avec les produits qui sont dans le panier (CartService)


        foreach($this->cartService->getDetailedCartItems() as $cartItem) {
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

        $this->cartService->empty();

        $this->addFlash("succes","Votre commande a bien été enregistré");
        return $this->redirectToRoute("purchase_index");
         
    }
    
}