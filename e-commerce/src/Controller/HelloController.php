<?php

namespace App\Controller;



use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class  HelloController extends AbstractController
{   

// protected $calculator;
// public function __construct(Calculator $calculator)
// {
//     $this->calculator = $calculator;
// }
    #[Route("/hello/{prenom?WORLD}", name:"hello")]
/* SI JE MET LE SERVICE DE CALCUL DANS LA FONCTION, pour laisser le nom world 
apparaitre je dois le mettre dans le parametre de la route */ 
    public function hello($prenom="World")
    {
        
// $this->logger->error("Mon message de log !");
// $slugify = new Slugify(); 
/** pour le mettre dans la function il faut le gerer dans
//  le dossier services.yaml car pas connu du container de sevice, placé dans vendor ! */

        $html = $this->render ('hello.html.twig', [
            'prenom'=> $prenom,
            'formateur1'=> ['prenom'=>'Mohamed', 'nom'=> 'El korchi'],
            'formateur2'=> ['prenom'=>'Lior', 'nom'=>'Chamla'],
        ]);
        return new Response($html);
    }

    #[Route("/example", name:"example")]

    public function example ()
    {
        $html = $this->render("example.html.twig", ["age"=>33]);
        return new Response($html);
    }
    
}