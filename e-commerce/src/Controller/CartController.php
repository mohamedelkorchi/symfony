<?php

namespace App\Controller;

use App\cart\CartService;
use App\Form\CartConfirmationType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{
    protected $productRepository;
    protected $cartService;
    public function __construct(ProductRepository $productRepository, CartService $cartService)
    {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
    }


    #[Route('/cart/add/{id}', name: 'cart_add', requirements:["id"=>"\d+"])]
    public function add($id, Request $request): Response
    {
        $product = $this->productRepository->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException("Le produit $id n'existe pas !");
        }

     $this->cartService->add($id);
       
       $this->addFlash("success", "Le produit a bien été ajouté au panier :)"); /** raccourcis de la ligne suivante et retiré le flashbaginterface */
    //    $flashBag->add("success", "Produit bien ajouté");
       
        if($request->query->get("returnToCart"))
        {
            return $this->redirectToRoute("cart_show");
        }

       return $this->redirectToRoute("product_show", [
        "category_slug" => $product->getCategory()->getSlug(),
        "slug" => $product->getSlug()
       ]);
    }

    #[Route('/cart', name: 'cart_show')]
    // #[IsGranted('ROLE_USER', message:"Vous n'etes pas connecté ")]
    public function show(){

        $form = $this->createForm(CartConfirmationType::class);

        $detailedCart = $this->cartService->getDetailedCartItems();

        $total = $this->cartService->getTotal();

        return $this->render("cart/index.html.twig", [
            "items" => $detailedCart,
            "total" => $total,
            "confirmationForm" => $form->createView()
        ]);
    }

    #[Route('/cart/delete/{id}', name: 'cart_delete', requirements: ["id"=> "\d+"])]
    public function delete($id)
    {
        $product = $this->productRepository->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException("Le produit $id n'existe pas et ne peut pas être supprimé !");
        }

        $this->cartService->remove($id);

        $this->addFlash("success", "Le produit a bien été supprimé du panier ");

        return $this->redirectToRoute("cart_show");
    }

    #[Route('/cart/decrement/{id}', name: 'cart_decrement', requirements: ["id"=> "\d+"])]

    public function decrement($id)
    {
        $product = $this->productRepository->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException("Le produit $id n'existe pas et ne peut pas être décrémenté !");
        }

        $this->cartService->decrement($id);

        $this->addFlash("success", "Votre article a bien été décrémenté  ");

        return $this->redirectToRoute("cart_show");
    }

}
