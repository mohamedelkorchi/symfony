<?php 

namespace App\cart;


// use App\Entity\Product;
use App\Entity\Product;
use App\Repository\ProductRepository;

class CartItem
{
    public $product;
    public $qty;

    public function __construct(Product $product, int $qty)
    {
        $this->product = $product;

        $this->qty = $qty;
    }

    public function getTotal() : int
    {
        return $this->product->getPrice() * $this->qty;
    }
}