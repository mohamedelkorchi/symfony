<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController 
{
    public function index()
    {
        var_dump('ca fonctionne');
        die();
    }
    
    /*
    * @Route("/test/{age<\d+>?0}",name="test", methods={"GET", "POST"};
    hots="localhost", schemes={"http","https"})
    */
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