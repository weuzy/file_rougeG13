<?php
namespace App\Controller;

use App\Entity\ProfilDeSortie;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @var EntityManagerInterface
 */
class ArchivageProfilDeSortieController
{
    private $archive;
    public function __construct(EntityManagerInterface $manager)
    {
        $this -> archive = $manager;
    }
    public function __invoke(ProfilDeSortie $data): ProfilDeSortie
    {
         $data -> setArchives(1);
        //$this -> archive -> persist($update);
        $this -> archive -> flush();
        return $data;
    }
}