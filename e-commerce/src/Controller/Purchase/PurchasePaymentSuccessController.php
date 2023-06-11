<?php 

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\cart\CartService;

use App\Event\PurchaseSuccessEvent;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentSuccessController extends AbstractController {

    #[Route("/purchase/terminate/{id}", name:"purchase_payment_success")]
    #[IsGranted("ROLE_USER")]
    public function success($id, PurchaseRepository $purchaseRepository, EntityManagerInterface $em,
    CartService $cartService, EventDispatcherInterface $dispatcher){

        //1. recuperer la commande
        $purchase = $purchaseRepository->find($id);

        if(!$purchase || ($purchase && $purchase->getUser() !== $this->getUser() || 
        ($purchase && $purchase->getStatus() === Purchase::STATUS_PAID) )) {
            $this->addFlash("warning","La commande n'existe pas !");
            return $this->redirectToRoute("purchase_index");
        }

        //2. fait passer au status paid
        $purchase->setStatus(Purchase::STATUS_PAID);
        $em->flush();

        //3. vide le panier
        $cartService->empty();

        //Lancer un événevement qui permette aux autres dev de réagir à la prise d'une commande
        $purchaseEvent = new PurchaseSuccessEvent($purchase);
        $dispatcher->dispatch($purchaseEvent, "purchase.success");


        //4. redigirer avec un flash
        $this->addFlash("success","La commande a été confirmée :)");
        return $this->redirectToRoute("purchase_index");
    }

    
}