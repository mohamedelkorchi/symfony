<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    public function index(SessionInterface $session): Response
    {
        $panier = $session->get("panier", []);

        return $this->render('accueil/navbar.html.twig', [
            'panier' => $panier
        ]);
    }
}
