<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Categorie;
use App\Entity\SeCompose;
use App\Entity\SousCategorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
                                                                       use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hash){
        $this->hasher = $hash;
    }
    public function load(ObjectManager $manager): void
    {
       
        // $u1 = new User;
        // $u1->setEmail("admin1@hotmail.fr");
        // $u1->setRoles(["ROLE_ADMIN"]);
        // $u1->setPassword($this->hasher->hashPassword($u1, "1234"));
        // $manager->persist($u1);

        // $u2 = new User;
        // $u2->setEmail("admin2@hotmail.fr");
        // $u2->setRoles(["ROLE_ADMIN"]);
        // $u2->setPassword($this->hasher->hashPassword($u2, "1234"));
        // $manager->persist($u2);

        // $u3 = new User;
        // $u3->setEmail("test@hotmail.fr");
        // $u3->setRoles(["ROLE_USER"]);
        // $u3->setPassword($this->hasher->hashPassword($u3, "0000"));
        // $manager->persist($u3);



        $categorie1 = new Categorie();
        $categorie1 ->setCatNom("Homme");
        $categorie1 -> setCatType("shoes");
        $categorie1 -> setImage("cat1.png");
        $manager ->persist($categorie1);

        $categorie2 = new Categorie();
        $categorie2 ->setCatNom("Femme");
        $categorie2 -> setCatType("shoes");
        $categorie2 -> setImage("cat2.png");
        $manager ->persist($categorie2);

        $categorie3 = new Categorie();
        $categorie3 ->setCatNom("Enfant");
        $categorie3 -> setCatType("shoes");
        $categorie3 -> setImage("cat3.png");
        $manager ->persist($categorie3);
        


            $sousCategorie1 = new SousCategorie();
            $sousCategorie1 ->setSousCatNom("sneakers");
            $sousCategorie1 -> setSousCatType("shoes");
            $sousCategorie1 -> setImage("souscat1.png");
            $sousCategorie1 ->setCategorie($categorie1);
            $manager ->persist($sousCategorie1);

            $sousCategorie2 = new SousCategorie();
            $sousCategorie2 ->setSousCatNom("sneakers");
            $sousCategorie2 -> setSousCatType("shoes");
            $sousCategorie2 -> setImage("souscat2.png");
            $sousCategorie2 ->setCategorie($categorie2);
            $manager ->persist($sousCategorie2);

            $sousCategorie3 = new SousCategorie();
            $sousCategorie3 ->setSousCatNom("sneakers");
            $sousCategorie3 -> setSousCatType("shoes");
            $sousCategorie3 -> setImage("souscat3.png");
            $sousCategorie3 ->setCategorie($categorie3);
            $manager ->persist($sousCategorie3);



            $sousCategorie4 = new SousCategorie();
            $sousCategorie4 ->setSousCatNom("ville");
            $sousCategorie4 -> setSousCatType("shoes");
            $sousCategorie4 -> setImage("souscat4.png");
            $sousCategorie4 ->setCategorie($categorie1);
            $manager ->persist($sousCategorie4);

            $sousCategorie5 = new SousCategorie();
            $sousCategorie5 ->setSousCatNom("ville");
            $sousCategorie5 -> setSousCatType("shoes");
            $sousCategorie5->setImage("souscat5.png");
            $sousCategorie5 ->setCategorie($categorie2);
            $manager ->persist($sousCategorie5);

            $sousCategorie6 = new SousCategorie();
            $sousCategorie6 ->setSousCatNom("ville");
            $sousCategorie6 -> setSousCatType("shoes");
            $sousCategorie6 -> setImage("souscat6.png");
            $sousCategorie6 ->setCategorie($categorie3);
            $manager ->persist($sousCategorie6);



            $sousCategorie7 = new SousCategorie();
            $sousCategorie7 ->setSousCatNom("claquettes");
            $sousCategorie7 -> setSousCatType("shoes");
            $sousCategorie7 -> setImage("souscat7.png");
            $sousCategorie7 ->setCategorie($categorie1);
            $manager ->persist($sousCategorie7);

            $sousCategorie8 = new SousCategorie();
            $sousCategorie8 ->setSousCatNom("claquettes");
            $sousCategorie8 -> setSousCatType("shoes");
            $sousCategorie8 -> setImage("souscat8.png");
            $sousCategorie8 ->setCategorie($categorie2);
            $manager ->persist($sousCategorie8);

            $sousCategorie9 = new SousCategorie();
            $sousCategorie9 ->setSousCatNom("claquettes");
            $sousCategorie9 -> setSousCatType("shoes");
            $sousCategorie9 -> setImage("souscat9.png");
            $sousCategorie9 ->setCategorie($categorie3);
            $manager ->persist($sousCategorie9);



            $sousCategorie10 = new SousCategorie();
            $sousCategorie10 ->setSousCatNom("accessoires");
            $sousCategorie10 -> setSousCatType("shoes");
            $sousCategorie10 -> setImage("souscat10.png");
            $sousCategorie10 ->setCategorie($categorie1);
            $manager ->persist($sousCategorie10);

            $sousCategorie11 = new SousCategorie();
            $sousCategorie11 ->setSousCatNom("accessoires");
            $sousCategorie11 -> setSousCatType("shoes");
            $sousCategorie11->setImage("souscat10.png");
            $sousCategorie11 ->setCategorie($categorie2);
            $manager ->persist($sousCategorie11);

            $sousCategorie12 = new SousCategorie();
            $sousCategorie12 ->setSousCatNom("accessoires");
            $sousCategorie12 -> setSousCatType("shoes");
            $sousCategorie12 -> setImage("souscat10.png");
            $sousCategorie12 ->setCategorie($categorie3);
            $manager ->persist($sousCategorie12);



                $produit1 = new Produit();
                $produit1 ->setName("Asics");
                $produit1 ->setDescription("bg la paire le mec");
                $produit1 ->setPrix("180");
                $produit1 -> setImage("asicsh.png");
                $produit1 ->setSousCategorie($sousCategorie1);
                $manager ->persist($produit1);

                $produit2 = new Produit();
                $produit2 ->setName("Asics femme");
                $produit2 ->setDescription("a l'aise Madame");
                $produit2 ->setPrix("190");
                $produit2 -> setImage("asicsf.png");
                $produit2 ->setSousCategorie($sousCategorie2);
                $manager ->persist($produit2);

                $produit3 = new Produit();
                $produit3 ->setName("Asics enfant");
                $produit3 ->setDescription("futur sportif");
                $produit3 ->setPrix("90");
                $produit3 -> setImage("asicse.png");
                $produit3 ->setSousCategorie($sousCategorie3);
                $manager ->persist($produit3);

                $produit4 = new Produit();
                $produit4 ->setName("timberland");
                $produit4 ->setDescription("un vrai ancien");
                $produit4 ->setPrix("140");
                $produit4 -> setImage("villeh.png");
                $produit4 ->setSousCategorie($sousCategorie4);
                $manager ->persist($produit4);

                $produit5 = new Produit();
                $produit5 ->setName("Timberland femme");
                $produit5 ->setDescription("a l'americaine");
                $produit5 ->setPrix("145");
                $produit5 -> setImage("villef.png");
                $produit5 ->setSousCategorie($sousCategorie5);
                $manager ->persist($produit5);

                $produit6 = new Produit();
                $produit6 -> setName("timberland enfant");
                $produit6 -> setDescription("tro chou");
                $produit6 -> setPrix("95");
                $produit6 -> setImage("villee.png");
                $produit6 -> setSousCategorie($sousCategorie6);
                $manager -> persist($produit6);

                $produit7 = new Produit();
                $produit7 ->setName("claquette homme");
                $produit7 ->setDescription("l'été approche monsieur");
                $produit7->setPrix("45");
                $produit7 -> setImage("claquetteh.png");
                $produit7 -> setSousCategorie($sousCategorie7);
                $manager -> persist($produit7);

                $produit8 = new Produit();
                $produit8 ->setName("claquette femme");
                $produit8 -> setDescription("a vos transates mesdames");
                $produit8 -> setPrix("25");
                $produit8 -> setImage("claquettef.png");
                $produit8 -> setSousCategorie($sousCategorie8);
                $manager -> persist($produit8);

                $produit9 = new Produit();
                $produit9 ->setName("claquette enfant");
                $produit9 -> setDescription("regardez ses petit doigts de pied");
                $produit9 -> setPrix("10");
                $produit9 -> setImage("claquettee.png");
                $produit9 -> setSousCategorie($sousCategorie9);
                $manager -> persist($produit9);

                $produit10 = new Produit();
                $produit10 ->setName("lacet");
                $produit10 -> setDescription("petite touche perso");
                $produit10 -> setPrix("13");
                $produit10->setImage("laceth.png");
                $produit10 -> setSousCategorie($sousCategorie10);
                $manager -> persist($produit10);

                $produit11 = new Produit();
                $produit11 ->setName("lacet");
                $produit11 -> setDescription("petite touche perso");
                $produit11 -> setPrix("13");
                $produit11 -> setImage("lacetf.png");
                $produit11 -> setSousCategorie($sousCategorie11);
                $manager -> persist($produit11);

                $produit12 = new Produit();
                $produit12 ->setName("lacet");
                $produit12 -> setDescription("petite touche perso");
                $produit12 -> setPrix("13");
                $produit12 -> setImage("lacete.png");
                $produit12 -> setSousCategorie($sousCategorie12);
                $manager -> persist($produit12);


                $produit13 = new Produit();
                $produit13 ->setName("semelle");
                $produit13 -> setDescription("pour plus de confort");
                $produit13 -> setPrix("19");
                $produit13->setImage("semelle.png");
                $produit13 -> setSousCategorie($sousCategorie10);
                $manager->persist($produit13);

                $produit14 = new Produit();
                $produit14 ->setName("semelle");
                $produit14 -> setDescription("pour plus de confort");
                $produit14 -> setPrix("19");
                $produit14 -> setImage("semelle.png");
                $produit14 -> setSousCategorie($sousCategorie11);
                $manager->persist($produit14);


                $produit15 = new Produit();
                $produit15 ->setName("entretien");
                $produit15 -> setDescription("pour une paire toujours neuve");
                $produit15 -> setPrix("10");
                $produit15->setImage("entretien.png");
                $produit15 -> setSousCategorie($sousCategorie10);
                $manager -> persist($produit15);

                $produit16 = new Produit();
                $produit16 ->setName("entretien");
                $produit16 -> setDescription("pour une paire toujours neuve");
                $produit16 -> setPrix("12");
                $produit16->setImage("entretien.png");
                $produit16 -> setSousCategorie($sousCategorie11);
                $manager -> persist($produit16);

                $produit17 = new Produit();
                $produit17 ->setName("entretien");
                $produit17 -> setDescription("pour une paire toujours neuve");
                $produit17 -> setPrix("10");
                $produit17->setImage("laver.png");
                $produit17 -> setSousCategorie($sousCategorie12);
                $manager -> persist($produit17);

        // $com1 = new Commande();
        // $com1->setUser($u2);
        // $com1->setDateCommande(new DateTime());
        // $manager->persist($com1);

        // $sc1 = new SeCompose();
        // $sc1->setProduit($produit1);
        // $sc1->setCommande($com1);
        // $sc1->setQuantite(3);
        // $manager->persist($sc1);

        // $sc2 = new SeCompose();
        // $sc2->setProduit($produit5);
        // $sc2->setCommande($com1);
        // $sc2->setQuantite(4);
        // $manager->persist($sc2);



        $manager->flush();
    }
}
