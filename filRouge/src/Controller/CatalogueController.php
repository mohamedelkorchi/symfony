<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $repo): Response
    {

        $categories =$repo->findAll();

        return $this->render('catalogue/categories.html.twig', [
            'categories' => $categories,
            
        ]);
    }


    #[Route('/categorie/{categorie}', name: 'souscategories')]
    public function souscategories(SessionInterface $session, CategorieRepository $repo, $categorie): Response
    {

        $cat = $repo->find($categorie);
        $scat = $cat->getSousCategorie(); // pas besoin du sous categorie repository car je recupere avec le get !

        return $this->render('catalogue/sousCategories.html.twig', [
            'liste_souscategories' => $scat,
            'panier' => $session->get("panier", []),
           
        ]);
    }



    #[Route('/souscategories/{souscat}', name: 'produits')]
    public function produits(SessionInterface $session, ProduitRepository $repo, $souscat): Response
    {
        

        $prod = $repo->findBy([ "sousCategorie" => $souscat ]);
        
        return $this->render('catalogue/produits.html.twig', [
            'liste_produits' => $prod,
            'panier' => $session->get("panier", []),
           
        ]);
    }



    #[Route('/detailproduit/{produit}', name: 'produit')]
    public function produit(SessionInterface $session, ProduitRepository $repo, $produit): Response
    {
        

        // $produit = $repo->findBy([ "Produit" => $produit ]);
        
        return $this->render('catalogue/detailproduit.html.twig', [
            'detail_produit' => $repo -> find($produit),
            'panier' => $session->get("panier", []),
           
        ]);
    }



   
}
