<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProductController extends AbstractController
{
    #[Route('/{slug}', name: 'product_category')]
    public function category($slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy([
            "slug" => $slug
        ]);
        
        if (!$category) {
            throw new NotFoundHttpException("La catégorie demandé n'existe pas!");
        }

        return $this->render('product/category.html.twig', [
            'controller_name' => 'ProductController',
            "slug" => $slug,
            "category" => $category,
        ]);
    }

   
    #[Route('/{category_slug}/{slug}', name: 'product_show')]

    public function show($slug, ProductRepository $productRepository)
    {
      

        $product = $productRepository->findOneBy([
            "slug" => $slug,
        ]);

        if(!$product) {
            throw new NotFoundHttpException("Ce produit n'existe pas!");
        }
        return $this->render("product/show.html.twig", [
            "product" => $product
        ]);
    }

    #[Route('/admin/product/create', name: 'product_create')]
    public function create()
    {
        return $this->render("product/create.html.twig");
    }

}
