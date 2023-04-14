<?php

namespace App\Controller;



use App\Controller\Taxes\Calculator;
use App\Controller\Taxes\Detector;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;


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
    public function hello($prenom="World", Environment $twig)
    {
        // $this->logger->error("Mon message de log !");
        // $slugify = new Slugify(); 
        /** pour le mettre dans la function il faut le gerer dans
        //  le dossier services.yaml car pas connu du container de sevice, placé dans vendor ! */

        $html = $twig->render ('hello.html.twig', [
            'prenom'=> $prenom]);
        return new Response($html);
    }
}