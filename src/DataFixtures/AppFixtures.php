<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $password;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this -> password = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $profils = ["ADMIN", "FORMATEUR", "APPRENANT", "CM"];
        foreach ($profils as $key => $libelle) {
           $profil = new Profil();
           $profil -> setLibelle($libelle)
                   -> setArchives(0);
           $manager -> persist($profil);
           for ($i=1; $i <3 ; $i++) { 
              $user = new User();
              $user -> setPrenom($faker -> firstName)
                    -> setNom($faker -> lastName)
                    -> setEmail($faker -> email)
                    -> setUsername(strtolower ($libelle).$i)
                    -> setGenre($faker -> randomElement(["M","F"])) 
                    -> setPhoto($faker -> imageUrl($width = 640, $height = 480))
                    -> setTelephone($faker -> phoneNumber)
                    -> setProfil($profil)
                    -> setArchives(0);
              $pass  =  $this -> password -> encodePassword($user, "cbagcrack");
              $user -> setPassword($pass);
              $manager -> persist($user);
              $manager -> flush();
           }
        }
    }
}
