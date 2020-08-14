<?php

namespace App\Controller;

use App\Entity\GroupesDeCompetences;
use App\Entity\Referentiel;
use App\Repository\GroupesDeCompetencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{
    /**
     * @Route(
     *     name="add_referentiel",
     *     path="/api/referentiels",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\ReferentielController::addReferentiel",
     *          "__api_resource_class"=Referentiel::class,
     *          "__api_collection_operation_name"="add_referentiel"
     *     }
     * )
     */
    public function addReferentiel(Request $request,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $manager,GroupesDeCompetencesRepository $repogrp)
    {
        $refer=json_decode($request->getContent(), true);
        $referent=new Referentiel();

        $referent -> setLibelle($refer['libelle'])
                  -> setDescription($refer['description'])
                  ->setCritereDAdmission($refer['critereDEvaluation'])
                  ->setCritereDEvaluation($refer['critereDAdmission'])
                  -> setProgramme($refer['programme'])
        ;
       foreach($refer['groupeDeCompetence'] as $id_g_comp){
            $referent->addGroupeDeCompetence($repogrp->find($id_g_comp));
        }

        $errors = $validator->validate($referent);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }


        $referent -> setArchive(1);
        $manager->persist($referent);
        $manager->flush();
        return $this->json("success",Response::HTTP_CREATED);
    }
}
