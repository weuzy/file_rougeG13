<?php

namespace App\Controller;
use App\Entity\Promo;
use App\Repository\PromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function addPromo(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager)
    {
        $promo = $request->request->all();
        $avatar = $request->files->get("avatar");
        $avatar = fopen($avatar->getRealPath(), "rb");
        $promo["avatar"] = $avatar;
        $promo = $serializer->denormalize($promo, "App\Entity\Promo");
        $errors = $validator->validate($promo);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
        $promo->setArchive(1);
        $manager->persist($promo);
        $manager->flush();
        fclose($avatar);
        return $this->json($serializer->normalize($promo), Response::HTTP_CREATED);
    }
}