<?php 

namespace App\Controller\Purchase;

use App\cart\CartService;
use App\Form\CartConfirmationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class PurchaseConfirmationController extends AbstractController
{
    protected $formFactory;
    protected $router;
    protected $security;
    protected $cartService;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router, Security $security,
    CartService $cartService)
    {
        $this->security = $security;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->cartService = $cartService;
    }

    #[Route("/purchase/confirm", name:"purchase_confirm")]
    public function confirm(Request $request, FlashBagInterface $flashBag ){

    //1. lire les données du formulaire 
    // formfactoryinterface / request 

        $form = $this->formFactory->create(CartConfirmationType::class);

        $form->handleRequest($request);

    //2. Si le formulaire n'a pas été soumis : oust

        if(!$form->isSubmitted()){
            $flashBag->add("warning","Vous devez remplir le formulaire de confirmation");
            return new RedirectResponse($this->router->generate("cart_show"));
        }

    //3. Si je ne suis pas connecté : oust (Security)

        $user = $this->security->getUser();

        if(!$user){
            throw new AccessDeniedException("Vous devez etre connecté pour confirmer une commande ");
        }

    //4. Si il n'y a pas de produits dans mon panier : oust (cartservice)
        
        $cartItems = $this->cartService->getDetailedCartItems();

        if(count($cartItems) === 0){
            $flashBag->add("warning","Vous ne pouvez confirmer une commande avec un panier vide !");

            return new RedirectResponse($this->router->generate("cart_show"));
        }


    }
    
}