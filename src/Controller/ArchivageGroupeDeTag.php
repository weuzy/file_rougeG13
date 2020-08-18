<?php
namespace App\Controller;

use App\Entity\GroupeDeTag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompetencesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;




class ArchivageGroupeDeTag
{
    private $archives;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archives = $manager;
    }

    public function __invoke(GroupeDeTag $data): GroupeDeTag
    {
        $data -> setArchives(1);
        $this -> archives -> flush();
        return $data;
    }

    /**
     * @Route(
     *     name="add_groupeTag",
     *     path="/api/addGroupeDeTags",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\ArchivageGroupeDeTag::addGroupeDeTag",
     *          "__api_resource_class"=GroupeDeTag::class,
     *          "__api_collection_operation_name"="add_groupeDeTag"
     *     }
     * )
    */
    public function addGroupeDeTag(Request $request,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $manager, TagRepository $tags)
    {
        $tab = json_decode($request->getContent(), true);
        $groupes = new GroupeDeTag();
        $groupes -> setLibelle($tab["libelle"]);
                 foreach($tab['tags'] as $id_tag){
                    $groupes->addTag($tags->find($id_tag));
                   }
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