<?php

namespace App\Controller;
use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class GroupeController extends AbstractController
{
    /**
     * @Route(
     *      name="groupe_liste",
     *      path="api/groupes",
     *      methods={"GET"},
     *      defaults={
     *          "_controller"="\app\ControllerGroupeController::showGroupe",
     *          "_api_resource_class"=Groupe::class,
     *          "_api_collection_operation_name"="get_groupe"
     *      }
     * )
     */
    public function showGroupe(GroupeRepository $repo)
    {
        $groupe= $repo->findByArchive("1");
        return $this->json($groupe,Response::HTTP_OK);
    }

    /**
     * @Route(
     *     path="/api/groupes",
     *     name="groupe_add",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\GroupeController::addGroupe",
     *          "__api_resource_class"=Groupe::class,
     *          "__api_collection_operation_name"="add_groupe"
     *     }
     * )
     */
    public function addGroupe(Request $request,ValidatorInterface $validator,SerializerInterface $serializer)
    {
        $groupe = $serializer->deserialize($request->getContent(), Groupe::class,'json');
        $errors = $validator->validate($groupe);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $date = $request->request->get("date_creation");
        $groupe->setDateCreation(new \DateTime($date));
        $groupe->setArchive(1);
        $entityManager->persist($groupe);
        $entityManager->flush();
        return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
    }

}