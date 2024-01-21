<?php

namespace App\Controller;

use DateTime;
use App\Entity\Commande;
use App\Entity\SeCompose;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    // #[Route('/checkout', name: 'app_checkout')]
    // public function index(): Response
    // {
    //     return $this->render('checkout/index.html.twig', [
    //         'controller_name' => 'CheckoutController',
    //     ]);
    // }

    #[Route('/checkout', name: 'app_checkout')]
    public function valider(ProduitRepository $repo, SessionInterface $session, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if (!$user){
            return $this->redirect("/login");
        }


        $panier = $session->get("panier", []);
       
        $com = new Commande();
        $com->setUser($this->getUser());
        $com->setDateCommande(new DateTime());
        $manager->persist($com);
        
        foreach($panier as $produit){

            $p = $repo->find($produit->getId());
            $qte = $produit->quantite;
            $sc = new SeCompose();
            $sc->setCommande($com);
            $sc->setProduit($p);
            $sc->setQuantite($qte);
            $manager->persist($sc);
            
            $manager->flush();    
            
        }        
        
        $session->set("panier", []);

        return $this->redirect("/panier");

        
    } 
}
