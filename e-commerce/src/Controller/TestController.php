<?php 

namespace App\Controller;

use App\Controller\Taxes\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController 
{
    // protected $calculator;
    // public function __construct(Calculator $calculator)
    // {
    //     $this->calculator = $calculator;
    // }
 

    #[Route("/", name:"index")]
    public function index()
    {
    //     $tva = $this->calculator->calcul(1400);
    //     dump($tva);
    dump("ca fonctionne");
        return new Response ("éviter le die lors d'un simple dump");
       
    }
    
    
    #[Route("/test/{age<\d+>?0}",name:"test", methods:["GET", "POST"],
     schemes:["http","https"])]
    
    public function test(Request $request, $age)
    {
        // $request = Request::createFromGlobals();

        // $age = $request->attributes->get("age");
        // dump($request);

        // $age = 0;
        // if  (!empty($_GET["age"])){
        //     $age = $_GET["age"];
        // }
       
        dump("t'as $age ans");
        return new Response("vous avez $age ans bg");
        
    }
}