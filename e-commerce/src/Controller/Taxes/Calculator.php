<?php

namespace App\Controller\Taxes;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class Calculator extends AbstractController
{
    protected $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function calcul(float $prix):float
    {
        $this->logger->info("un calcul a été fait : $prix");
        return $prix * (20/100);
    }
}