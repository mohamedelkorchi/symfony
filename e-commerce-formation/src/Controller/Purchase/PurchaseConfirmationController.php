<?php 

namespace App\Controller\Purchase;


use App\Entity\Purchase;
use App\cart\CartService;

use App\Form\CartConfirmationType;
use App\Purchase\PurchasePersister;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PurchaseConfirmationController extends AbstractController
{
    
    
   
    protected $cartService;
    protected $em;
    protected $persister;

    public function __construct( CartService $cartService, EntityManagerInterface $em, PurchasePersister $persister)
    {
        $this->em = $em;
        $this->persister = $persister;      
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

        // $user = $this->getUser();

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

        $this->persister->storePurchase($purchase);

        return $this->redirectToRoute("purchase_payment_form", [
            "id" => $purchase->getId()
        ]);
         
    }
    
}