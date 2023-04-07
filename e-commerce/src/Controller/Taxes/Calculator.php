<?php

namespace App\Controller\Taxes;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class Calculator extends AbstractController
{
    public function calcul(float $prix):float
    {
        return $prix * (20/100);
    }
}