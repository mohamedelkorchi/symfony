<?php

namespace App\Controller;

use App\Entity\Product;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(ProductRepository $productRepository): Response
    {
       $products = $productRepository->findBy([],[],3);
       
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "products" => $products
        ]);
    }
}
