<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository): Response
    {

        $panier = $session->get("panier", []);
        // Fabrication de données:

        $datapanier = [];
        $total = 0;

        // dd($panier);
        
        foreach($panier as $id => $produit)
        {
            $datapanier[] = [
                "produit" => $produit,
                "quantite" => $produit->quantite
            ];
            $total += $produit->getPrix() * $produit->quantite;
        }
        return $this->render('panier/index.html.twig', [
            'datapanier' => $datapanier,
            'total' => $total,
            'panier' => $panier
            //'categories' => $categories
        ]);
    }

        // return $this->render('panier/index.html.twig', [
        //     'panier' => $session->get("panier", [])
        // ]);
    




    #[Route('/add/{id}', name: 'app_add_panier')]
    public function add(SessionInterface $session,  Produit $id, ProduitRepository $repo): Response
    {
        $tab = $session->get("panier", []);

        $p = null;

        foreach ( $tab as $pro ) {
            if ($pro->getId() == $id->getId()){
                $p = $pro;
            }
        }

        if ($p==null) {
            $id->quantite = 1;
            $tab[] = $id;
        }

        else {
            $p->quantite++;
        }


        $session->set("panier", $tab);

        return $this->redirect("/panier");


    }

    #[Route('/remove/{id}', name: 'app_remove')]
    public function remove(SessionInterface $session, Produit $id): Response
    {
        
        $panier = $session->get("panier", []);

        $p = null;
        $position = 0;
        foreach ($panier as $i => $pro ){
            if ($pro->getId() == $id->getId()){
                $p = $pro;
                $position = $i;
            }
        }

        if ($p==null){
            // Le produit n'existe pas dans le panier
        }

        else{
            $p->quantite--;
            if($p->quantite == 0){
                unset($panier[$position]);
            }
        }
        // sauvegarde dans la session
        $session->set("panier", $panier);

        // on retient dans l'index
        return $this->redirect("/panier");
        
    }


    #[Route('/clear', name: 'app_clear_panier')]
    public function clear(SessionInterface $session): Response
    {
        $session->set("panier", []);

        return $this->redirect("/panier");
    }

    #[Route('/clear_produit/{id}', name: 'app_clear_produit')]
    public function clear_produit(int $id, SessionInterface $session, ProduitRepository $produitRepository): Response
    {
        $panier = $session->get("panier", []);
        // dd($panier);

        foreach ($panier as $k => $v) {
            if($v->getId()==$id) {
                unset($panier[$k]);

            }
        }
        $session->set("panier", $panier);

        return $this->redirect("/panier");
    }


    #[Route('/commandes', name: 'app_commandes')]
    public function commandes(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findBy([ "user" => $this->geTUser()]);

        return $this->render('/commandes/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }


    #[Route('/commandes_details/{id}', name: 'app_commandes_details')]
    public function commandes_details(Commande $id): Response
    {

        return $this->render('/commandes/commandes_details.html.twig', [
            'commande' => $id,
        ]);
    }
}


