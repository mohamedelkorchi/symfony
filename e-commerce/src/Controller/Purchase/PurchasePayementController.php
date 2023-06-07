<?php 

namespace App\Controller\Purchase;

use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PurchasePayementController extends AbstractController
{

    #[Route("/purchase/pay/{id}", name:"purchase_payment_form")]
    public function showCardForm($id, PurchaseRepository $purchaseRepository)
    {
        $purchase = $purchaseRepository->find($id);

        if(!$purchase) {
            return $this->redirectToRoute("card_show");
        }

        \Stripe\Stripe::setApiKey("sk_test_51NFzIEGF1fA55rcnl2N435sN6R3ZGqPWrSvnOfIMTDuMvHlDDfBF6nArur7a90B5yfDhh5C5FkHkpWY7t3dP1uXD00EtCsIaZr");

        $intent = \Stripe\PaymentIntent::create([
            "amount" => $purchase->getTotal(),
            "currency" => "eur"
        ]);
        

        return $this->render("purchase/payment.html.twig", [
            "clientSecret" => $intent->client_secret,
            "purchase" => $purchase
        ]);
    }


}