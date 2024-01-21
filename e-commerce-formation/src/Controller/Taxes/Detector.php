<?php

namespace App\Controller\Taxes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Detector extends AbstractController 
{

    protected $seuil;
    public function __construct($seuil)
    {
        $this->seuil = $seuil;
    }
    public function detect(float $detector) : bool
    {
        if($detector > $this->seuil)
        {
            return true;
        }
        return false;
    } 
}