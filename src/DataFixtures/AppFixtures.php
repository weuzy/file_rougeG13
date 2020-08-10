<?php

namespace App\DataFixtures;

use App\Entity\Actions;
use App\Entity\Apprenant;
use App\Entity\Competences;
use App\Entity\GroupeDeTag;
use App\Entity\GroupesDeCompetences;
use App\Entity\Niveau;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Profil;
use App\Entity\ProfilDeSortie;
use App\Entity\Tag;
use App\Repository\CompetencesRepository;
use App\Repository\ProfilDeSortieRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $password;
    public function __construct(UserPasswordEncoderInterface $encoder, ProfilDeSortieRepository $pro, CompetencesRepository $compet)
    {
        $this -> password = $encoder;
        $this -> pro = $pro;
        $this -> compet = $compet;
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

        $groupeDeComp = ["Développer le front-end d’une application web", "Développer le back-end d’une application web"];
        $competences = ["Créer une base de données", "Développer les composants d’accès aux données", "Élaborer et mettre en œuvre des composants dans une application de gestion de contenu ou e-commerce", "Maquetter une application", "Réaliser une interface utilisateur web", "Développer une interface utilisateur web dynamique"];
        $niveaux = ["niveau 1", "niveau 2", "niveau 3"];
        $tags = ["HTML5", "CSS3", "Node JS", "Javascript"];
        $groupes_de_tags = ["Développement Mobile", "Systèmes et réseaux","Objets connectés"];
        foreach ($groupeDeComp as $key => $libelle) {
            $groupe = new GroupesDeCompetences();
            $groupe -> setLibelle($libelle)
                    -> setDescriptif($faker -> text);
            for ($i=1; $i <3 ; $i++) { 
                $compete = new Competences();
                $compete -> setLibelle($faker -> randomElement($competences))
                         -> setDescriptif($faker -> text);
                $groupe -> addCompetence($compete);
                for ($i=1; $i <3 ; $i++) { 
                    $niveau = new Niveau();
                    $niveau -> setLibelle($faker -> randomElement($niveaux))
                            -> setDescription($faker-> text)
                            -> setCriterDEvaluation($faker -> text);
                   $compete -> addNiveau($niveau);
                   $manager -> persist($niveau);
                    for ($i=1; $i <3 ; $i++) { 
                        $action  = new Actions();
                        $action -> setLibelle($faker -> text)
                                -> setNiveau($niveau);
                       $manager -> persist($action);
                     }
                   }
                $manager -> persist($compete);
            }
                foreach ($tags as $key => $lib) {
                    $tag = new Tag();
                        $tag -> setLibelle($lib);
                        $manager -> persist($tag);
                        $groupe -> addTag($tag);
                    }
                foreach ($groupes_de_tags as $key => $libelle) {
                    $grp_tag = new GroupeDeTag();
                    $grp_tag -> setLibelle($libelle);
                    $grp_tag -> addTag($tag);
                    $manager -> persist($grp_tag);
                    }
                    
            $manager -> persist($groupe);
            $manager -> flush();
            
                

        }


    }
}
