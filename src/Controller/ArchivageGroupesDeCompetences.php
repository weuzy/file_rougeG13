<?php
namespace App\Controller;

use App\Entity\GroupesDeCompetences;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @var EntityManagerInterface
 */

class ArchivageGroupesDeCompetences
{
    private $archives;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archives = $manager;
    }

    public function __invoke(GroupesDeCompetences $data): GroupesDeCompetences
    {
        $data -> setArchives(1);
        $this -> archives -> flush();
        return $data;
    }
   
}