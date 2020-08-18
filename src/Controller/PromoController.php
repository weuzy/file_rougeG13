<?php

namespace App\Controller;
use App\Entity\Groupe;
use App\Entity\Promo;
use App\Repository\ProfilRepository;
use App\Repository\PromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class PromoController extends AbstractController
{
    /**
     * @Route(
     *      name="promo_liste",
     *      path="api/promos",
     *      methods={"GET"},
     *      defaults={
     *          "_controller"="\app\ControllerUserController::showPromo",
     *          "_api_resource_class"=Promo::class,
     *          "_api_collection_operation_name"="get_promo"
     *      }
     * )
     */
    public function showPromo(PromoRepository $repo,Request $request)
    {
        $page = (int) $request->query->get('page', 1);
        $promo= $repo->findByArchive("1",2,$page);
        return $this->json($promo,Response::HTTP_OK);
    }

    /**
     * @Route(
     *     path="/api/promos",
     *     name="promo_add",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\PromoController::addPromo",
     *          "__api_resource_class"=Promo::class,
     *          "__api_collection_operation_name"="add_promo"
     *     }
     * )
     */
    public function addPromo(Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager,\Swift_Mailer $mailer, ProfilRepository $repoProfil)
    {
        $promo=new Promo();
        $promo->setLibelle("Sonatel Academy")
            ->setArchive(1)
        ;
        $groupe=new Groupe();
        $groupe->setArchive(1)
            ->setLibelle("principal")
            ->setDateCreation(new \DateTime)
        ;

        /*$tab=["diopp1017@gmail.com"];
        for($i=0;$i<1;$i++) {
            $apprenant = new Apprenant();
            $apprenant->setGroupe($groupe)
                ->setStatut("actif");
            $utilisateur = new User();
            $password = "pass_1234";
            $utilisateur->setLogin("hihh".$i)
                ->setNom("FGGH".$i)
                ->setPrenom("hdehfhf".$i)
                ->setTelephone("786545669")
                ->setGenre("F")
                ->setAdresse("Louga")
                ->setEmail($tab[$i])
                ->setPassword($encoder->encodePassword($utilisateur, $password))
                ->setArchive(1);
        }*/

        /*$doc = $request->files->get("document");
        $file= IOFactory::identify($doc);
        $reader= IOFactory::createReader($file);
        $spreadsheet=$reader->load($doc);
        $array_contenu_fichier= $spreadsheet->getActivesheet()->toArray();
        //dd($array_contenu_fichier);
        $password="pass_1234";
        for ($i=1;$i<count($array_contenu_fichier);$i++){
            $apprenant = new Apprenant();
            $apprenant->setGroupe($groupe)
                ->setStatut("actif");
            $utilisateur=new User();
            $utilisateur->setLogin($array_contenu_fichier[$i][0])
                ->setPassword($encoder->encodePassword($utilisateur,$password))
                ->setNom($array_contenu_fichier[$i][1])
                ->setPrenom($array_contenu_fichier[$i][2])
                ->setTelephone($array_contenu_fichier[$i][3])
                ->setEmail($array_contenu_fichier[$i][4])
                ->setGenre($array_contenu_fichier[$i][5])
                ->setAdresse($array_contenu_fichier[$i][6])
                ->setArchive(1);
        }*/

        $utilisateur->setProfil($repoProfil->findOneByLibelle("APPRENANT"));
        $apprenant->setUser($utilisateur);
        $groupe->addApprenant($apprenant);

        $manager->persist($utilisateur);
        $manager->persist($apprenant);

        $message=(new\Swift_Message)
            ->setSubject('Orange Digital Center, SONATEL ACADEMY')
            ->setFrom('xxxxx@gmail.com')
            ->setTo($utilisateur->getEmail())
            ->setBody("Bienvenue cher apprenant vous avez intégré la nouvelle promotion de la première école de codage gratuite du Sénégal, veuillez utiliser ce login: ".$utilisateur->getLogin()." et ce password : ".$password." par defaut pour se connecter");
        $mailer->send($message);
        $promo->addGroupe($groupe);
        //dd($promo);
        $errors = $validator->validate($promo);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $manager->persist($groupe);
        $manager->persist($promo);
        $manager->flush();
        return $this->json($serializer->normalize($promo), Response::HTTP_CREATED);
    }
}