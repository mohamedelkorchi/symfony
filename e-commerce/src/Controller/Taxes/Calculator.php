<?php

namespace App\Controller\Taxes;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class Calculator extends AbstractController
{
    protected $logger;
    protected $tva;
    public function __construct(LoggerInterface $logger, float $tva)
    {
        $this->logger = $logger;
        $this->tva = $tva;
    }
    public function calcul(float $prix):float
    {
        $this->logger->info("un calcul a été fait : $prix");
        return $prix * (20/100);
    }
}