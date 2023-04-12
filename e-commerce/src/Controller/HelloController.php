<?php

namespace App\Controller;



use App\Controller\Taxes\Calculator;
use Cocur\Slugify\Slugify;
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
    public function hello($prenom="World", Calculator $calculator, Slugify $slugify)
    {
        // $this->logger->error("Mon message de log !");
        // $slugify = new Slugify(); 
        /** pour le mettre dans la function il faut le gerer dans
        //  le dossier services.yaml car pas connu du container de sevice, placé dans vendor ! */
    
        dump($slugify->slugify("Hello world"));
        $tva = $calculator->calcul(1400);
        dump($tva);
        return new Response("hello $prenom");
    }
}