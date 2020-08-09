<?php

namespace App\DataFixtures;

use App\Entity\Apprenant;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Profil;
use App\Entity\ProfilDeSortie;
use App\Repository\ProfilDeSortieRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $password;
    public function __construct(UserPasswordEncoderInterface $encoder, ProfilDeSortieRepository $pro)
    {
        $this -> password = $encoder;
        $this -> pro = $pro;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $metiers = ["Développeur front", "Développeur back", "fullstack", "CMS", "Intégrateur", "Designer", "CM", "Data"];
        foreach ($metiers as $key => $libelle) {
            $profil_de_sortie = new ProfilDeSortie();
            $profil_de_sortie -> setLibelle($libelle)
                              ->setArchives(0);
                $manager -> persist($profil_de_sortie);
                $manager -> flush();
        }
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
              if ($libelle == "APPRENANT") {
                $statut = ["actif", "renvoyé", "suspendu", "abandonné", "décédé"];
                $niveau = ["excellent", "bien", "abien", "faible"];
                $apprenant = new Apprenant();
                $apprenant -> setStatut($faker -> randomElement($statut))
                           -> setNiveau($faker -> randomElement($niveau))
                           -> setUser($user)
                           -> setProfilDeSortie($faker -> randomElement($this -> pro -> findAll() ));
                  $manager -> persist($apprenant);
              }
              $manager -> persist($user);
              $manager -> flush();
           }
        }
    }
}
