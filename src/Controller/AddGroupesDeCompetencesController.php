<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Entity\GroupesDeCompetences;
use App\Repository\CompetencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddGroupesDeCompetencesController extends AbstractController
{
     /**
     * @Route(
     *     name="add_groupeComp",
     *     path="/api/groupesDeCompetences",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\AddGroupesDeCompetencesController::AddGroupesDeCompetencesController",
     *          "__api_resource_class"=GroupesDeCompetences::class,
     *          "__api_collection_operation_name"="add_groupesDeCompetences"
     *     }
     * )
    */
    public function addGroupeComp(Request $request,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $manager, CompetencesRepository $compet)
    {
        $tab = json_decode($request->getContent(), true);
        $groupes = new GroupesDeCompetences();
        $groupes -> setLibelle($tab["libelle"])
                 -> setDescriptif($tab["descriptif"]);
                 foreach($tab['competences'] as $idcomp){
                    $groupes->addCompetence($compet->find($idcomp));
                   }
               //  -> addCompetence($compet -> find($tab["competences"]));
        //$groupes = $serializer->denormalize($groupes,"App\Entity\GroupesDeCompetences", true);
        //dd($groupes);
        $errors = $validator->validate($groupes);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $groupes -> setArchives(0);
        $manager -> persist($groupes);
        $manager -> flush();
        return $this -> json("success",Response::HTTP_CREATED);
    }
}
