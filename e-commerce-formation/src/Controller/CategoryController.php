<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/admin/category/create', name: 'category_create')]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger  ): Response
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $category->setSlug(strtolower($slugger->slug($category->getName()) ));

            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute("homepage");
        }

        $formView = $form->createView();

        return $this->render('category/create.html.twig', [
            'controller_name' => 'CategoryController',
            "formView" => $formView
            
        ]);
    }

    #[Route('/admin/category/{id}/edit', name: 'category_edit')]
    #[IsGranted('ROLE_ADMIN', message:"Vous n'etes pas l'admin ")]
    public function edit($id, CategoryRepository $categoryRepository, EntityManagerInterface $em,
    Request $request, SluggerInterface $slugger, Security $security ): Response
    {
        // $this->denyAccessUnlessGranted("ROLE_ADMIN", null, "Vous n'avez pas acces à cette page !");
        
        $category = $categoryRepository->find($id);

        // $this->denyAccessUnlessGranted("CAN_EDIT", $category, "Seul le créateur d'une catégorie peut la modifier");

        $form = $this->createForm(CategoryType::class, $category );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $category->setSlug(strtolower($slugger->slug($category->getName()) ));
            $em->flush();

            return $this->redirectToRoute("homepage");
        }

        $formView = $form->createView();

        return $this->render('category/edit.html.twig', [
            'controller_name' => 'CategoryController',
            "category" => $category,
            "formView"=> $formView
        ]);
    }
}
