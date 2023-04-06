<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController 
{
    #[Route("/hello/{prenom}", name:"hello")]

    public function hello($prenom="World")
    {
        return new Response("hello $prenom");
    }
}