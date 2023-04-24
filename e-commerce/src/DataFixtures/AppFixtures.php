<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Generator;

class AppFixtures extends Fixture
{
    protected $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
    //     $faker = Factory::create('fr_FR');
        // $faker->addProvider(new \Liior\Faker\Prices($faker));
        // $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        for ($p=0; $p <100 ; $p++)
        { 
            $product = new Product;
            $product->setName($this->faker->sentence())
                    ->setPrice($this->faker->price(4000, 20000))
                    ->setSlug($this->faker->slug());

            $manager->persist($product);       
        }

        $manager->flush();
    }
}
