<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route(
     *     name="add_user",
     *     path="/api/users",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::addUser",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="add_user"
     *     }
     * )
    */
    public function addUser(Request $request,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = $request->request->all();
        $avatar = $request->files->get("photo");
        $user = $serializer->denormalize($user,"App\Entity\User", true);
        $avatar = fopen($avatar->getRealPath(),"rb");
        $errors = $validator->validate($user);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $password = $user ->getPassword();
        $user -> setPassword($encoder -> encodePassword($user, $password));
        $user -> setPhoto($avatar);
        $user -> setArchives(0);
        $manager->persist($user);
        $manager->flush();
        fclose($avatar);
        return $this->json("success",Response::HTTP_CREATED);
    }
}
